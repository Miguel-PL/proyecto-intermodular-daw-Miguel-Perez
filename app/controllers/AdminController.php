<?php

// Controller responsible for admin panel actions
class AdminController
{
    // Displays the admin dashboard view
    public function dashboard(): void
    {
        // Check if user is logged in and has admin role
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            // Redirect unauthorized users to public home page
            header('Location: ' . APP_URL);
            exit;
        }

        // Load admin dashboard view
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }
}


