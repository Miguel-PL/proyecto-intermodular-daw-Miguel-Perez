<?php

// Load required models for reservation management
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../models/Court.php';
require_once __DIR__ . '/../models/User.php';

// Controller for admin reservation management
class AdminReservationController
{
    // Checks if current user is an administrator
    private function checkAdmin(): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            // Redirect non-admin users to public area
            header('Location: ' . APP_URL);
            exit;
        }
    }

    // Displays the list of all reservations
    public function index(): void
    {
        $this->checkAdmin();

        // Retrieve all reservations from database
        $reservations = Reservation::getAll();
        require_once __DIR__ . '/../views/admin/reservations/index.php';
    }

    // Cancels a reservation by admin action
    public function cancel(): void
    {
        $this->checkAdmin();

        // Get reservation id from URL
        $id = (int)($_GET['id'] ?? 0);
        Reservation::cancel($id);

        // Store warning flash message
        setFlash('warning', 'Reserva cancelada por el administrador');

        // Redirect back to reservation list
        header('Location: ' . APP_URL . '?controller=adminReservation&action=index');
        exit;
    }

    // Loads reservation edit form
    public function edit(): void
    {
        $this->checkAdmin();

        // Get reservation id from URL
        $id = (int)($_GET['id'] ?? 0);
        $reservation = Reservation::find($id);

        // If reservation does not exist, redirect with error
        if (!$reservation) {
            setFlash('danger', 'Reserva no encontrada.');
            header('Location: ' . APP_URL . '?controller=adminReservation&action=index');
            exit;
        }

        // Load related data for edit form
        $courts = Court::getAll();
        $users = User::getAll();

        require_once __DIR__ . '/../views/admin/reservations/edit.php';
    }

    // Updates reservation data
    public function update(): void
    {
        $this->checkAdmin();

        // Get reservation id from POST data
        $id = (int)($_POST['id'] ?? 0);

        // If id is invalid, redirect to list
        if (!$id) {
            header('Location: ' . APP_URL . '?controller=adminReservation&action=index');
            exit;
        }

        // Update reservation with new values
        Reservation::update($id, [
            'user_id' => (int)$_POST['user_id'],
            'court_id' => (int)$_POST['court_id'],
            'start_datetime' => $_POST['start_datetime'],
            'duration_minutes' => (int)$_POST['duration_minutes']
        ]);

        // Store success flash message
        setFlash('success', 'Reserva actualizada correctamente.');

        // Redirect back to reservation list
        header('Location: ' . APP_URL . '?controller=adminReservation&action=index');
        exit;
    }
}

