<?php

// Load User model for authentication
require_once __DIR__ . '/../models/User.php';

// Controller responsible for user authentication
class AuthController
{
    // Handles user login process
    public function login(): void
    {
        // Process login only on POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get and sanitize input data
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validate required fields
            if ($email === '' || $password === '') {
                $error = 'Email and password are required';
            } else {
                // Find user by email
                $user = User::findByEmail($email);

                // Verify password hash
                if ($user && password_verify($password, $user['password_hash'])) {
                    // Store user data in session
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['full_name'],
                        'role' => $user['role_name']
                    ];

                    // Redirect user based on role
                    if ($user['role_name'] === 'admin') {
                        header('Location: ' . APP_URL . '?controller=admin&action=dashboard');
                    } else {
                        header('Location: ' . APP_URL . '?controller=user&action=dashboard');
                    }
                    exit;
                } else {
                    // Invalid credentials
                    $error = 'Invalid credentials';
                }
            }
        }

        // Load login view
        require_once __DIR__ . '/../views/auth/login.php';
    }

    // Destroys session and logs out user
    public function logout(): void
    {
        session_destroy();
        header('Location: ' . APP_URL);
        exit;
    }
}

