<?php

// Load User model for profile management
require_once __DIR__ . '/../models/User.php';

// Controller for user dashboard and profile actions
class UserController
{
    // Displays user dashboard
    public function dashboard(): void
    {
        // Check if logged user has user role
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
            header('Location: ' . APP_URL);
            exit;
        }

        require_once __DIR__ . '/../views/user/dashboard.php';
    }

    // Loads password change form
    public function changePassword(): void
    {
        $this->checkUser();

        require_once __DIR__ . '/../views/user/change_password.php';
    }

    // Updates user password
    public function updatePassword(): void
    {
        $this->checkUser();

        // Only allow POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '?controller=user&action=dashboard');
            exit;
        }

        // Get form data
        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        // Check new password confirmation
        if ($new !== $confirm) {
            setFlash('danger', 'Las nuevas contraseñas no coinciden.');
            header('Location: ' . APP_URL . '?controller=user&action=changePassword');
            exit;
        }

        // Retrieve current user from database
        $user = User::findById($_SESSION['user']['id']);

        // Verify current password
        if (!password_verify($current, $user['password_hash'])) {
            setFlash('danger', 'La contraseña actual no es correcta.');
            header('Location: ' . APP_URL . '?controller=user&action=changePassword');
            exit;
        }

        // Update password with new hash
        User::updatePassword($user['id'], password_hash($new, PASSWORD_DEFAULT));

        setFlash('success', 'Contraseña actualizada correctamente.');
        header('Location: ' . APP_URL . '?controller=user&action=dashboard');
        exit;
    }

    // Checks if user is logged in
    private function checkUser(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . APP_URL);
            exit;
        }
    }
}

