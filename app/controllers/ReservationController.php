<?php

// Load required models for reservation management
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../models/Court.php';
require_once __DIR__ . '/../models/User.php';

// Controller for user and admin reservations
class ReservationController
{
    // Checks if user is logged in
    private function checkUser(): void
    {
        if (!isset($_SESSION['user'])) {
            // Redirect guests to public area
            header('Location: ' . APP_URL);
            exit;
        }
    }

    // Displays current user's reservations
    public function index(): void
    {
        $this->checkUser();

        // Retrieve reservations for logged user
        $reservations = Reservation::getByUser($_SESSION['user']['id']);
        require_once __DIR__ . '/../views/user/reservations/index.php';
    }

    // Creates a new reservation
    public function create(): void
    {
        $this->checkUser();

        // Check if current user is admin
        $isAdmin = $_SESSION['user']['role'] === 'admin';
        $users = [];

        // Admin can create reservations for any user
        if ($isAdmin) {
            $users = User::getAll();
        }

        // Load available courts
        $courts = Court::getAll();
        $error = null;

        // Handle reservation form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Get form data
            $courtId = (int)$_POST['court_id'];
            $start = $_POST['start_datetime'];
            $durationMinutes = (int)$_POST['duration_minutes'];

            // Calculate start and end time in minutes
            $startDate = new DateTime($start);
            $hour = (int)$startDate->format('H');
            $minute = (int)$startDate->format('i');

            $startMinutes = $hour * 60 + $minute;
            $endMinutes = $startMinutes + $durationMinutes;

            // Validate time slot (only full or half hours allowed)
            if (!in_array($minute, [0, 30])) {
                $error = 'Las reservas solo pueden comenzar en horas o medias horas';
            }

            // Validate club opening hours (08:00 - 23:00)
            if ($startMinutes < 480 || $endMinutes > 1380) {
                $error = 'La reserva debe estar dentro del horario del club (08:00 - 23:00)';
            }

            // Check availability and create reservation
            if (!$error && Reservation::isAvailable($courtId, $start, $durationMinutes)) {

                // Admin can choose user, normal user uses own id
                $userId = $isAdmin
                    ? (int)$_POST['user_id']
                    : $_SESSION['user']['id'];

                // Store reservation
                Reservation::create([
                    'user_id' => $userId,
                    'court_id' => $courtId,
                    'start_datetime' => $start,
                    'duration_minutes' => $durationMinutes
                ]);

                setFlash('success', 'Reserva creada correctamente');

                header('Location: ' . APP_URL . '?controller=reservation&action=index');
                exit;
            }
        }

        // Load reservation creation view
        require_once __DIR__ . '/../views/user/reservations/create.php';
    }

    // Cancels a user reservation
    public function cancel(): void
    {
        $this->checkUser();

        // Get reservation id from URL
        $id = (int)($_GET['id'] ?? 0);
        $reservation = Reservation::find($id);

        // Validate ownership and reservation status
        if (
            !$reservation ||
            $reservation['user_id'] !== $_SESSION['user']['id'] ||
            $reservation['status'] !== 'confirmed'
        ) {
            header('Location: ' . APP_URL . '?controller=reservation&action=index');
            exit;
        }

        // Check if reservation can still be canceled
        if (Reservation::canCancel($reservation)) {
            Reservation::cancel($id);
        }

        setFlash('success', 'Reserva cancelada correctamente');
        header('Location: ' . APP_URL . '?controller=reservation&action=index');
        exit;
    }

    // Returns reservation availability in JSON format (AJAX endpoint)
    public function availability(): void
    {
        $this->checkUser();

        // Set JSON response header
        header('Content-Type: application/json');

        // Get court id and date from request
        $courtId = (int)($_GET['court_id'] ?? 0);
        $date = $_GET['date'] ?? '';

        // Validate input parameters
        if (!$courtId || !$date) {
            echo json_encode([]);
            exit;
        }

        // Retrieve reservations for selected court and date
        $reservations = Reservation::getByCourtAndDate($courtId, $date);

        echo json_encode($reservations);
        exit;
    }
}

