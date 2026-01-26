<?php

// Load Court model for resource management
require_once __DIR__ . '/../models/Court.php';

// Controller for court (resource) administration
class CourtController
{
    // Checks if current user is an administrator
    private function checkAdmin(): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            // Redirect unauthorized users
            header('Location: ' . APP_URL);
            exit;
        }
    }

    // Displays list of courts
    public function index(): void
    {
        $this->checkAdmin();

        // Retrieve all courts
        $courts = Court::getAll();

        require_once __DIR__ . '/../views/admin/courts/index.php';
    }

    // Creates a new court
    public function create(): void
    {
        $this->checkAdmin();

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $imageName = null;

            // Process uploaded image if exists
            if (!empty($_FILES['image']['name'])) {
                $imageName = uniqid() . '_' . $_FILES['image']['name'];
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/assets/images/courts/' . $imageName
                );
            }

            // Create new court record
            Court::create([
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'max_players' => $_POST['max_players'],
                'image' => $imageName
            ]);

            header('Location: ' . APP_URL . '?controller=court&action=index');
            exit;
        }

        // Load court creation form
        require_once __DIR__ . '/../views/admin/courts/create.php';
    }

    // Edits an existing court
    public function edit(): void
    {
        $this->checkAdmin();

        // Get court id from URL
        $id = (int)($_GET['id'] ?? 0);
        $court = Court::find($id);

        // Redirect if court does not exist
        if (!$court) {
            header('Location: ' . APP_URL . '?controller=court&action=index');
            exit;
        }

        // Handle edit form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Keep current image by default
            $imageName = $court['image'];

            // Replace image only if a new one is uploaded
            if (!empty($_FILES['image']['name'])) {
                $imageName = uniqid() . '_' . $_FILES['image']['name'];
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/assets/images/courts/' . $imageName
                );
            }

            // Update court data
            Court::update($id, [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'max_players' => $_POST['max_players'],
                'image' => $imageName
            ]);

            header('Location: ' . APP_URL . '?controller=court&action=index');
            exit;
        }

        // Load court edit form
        require_once __DIR__ . '/../views/admin/courts/edit.php';
    }

    // Deletes a court (logical or physical depending on model)
    public function delete(): void
    {
        $this->checkAdmin();

        // Get court id from URL
        $id = (int)($_GET['id'] ?? 0);
        Court::delete($id);

        header('Location: ' . APP_URL . '?controller=court&action=index');
        exit;
    }
}

