<?php

// Load required models for user and role management
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Role.php';

// Controller for admin user management
class AdminUserController
{
    // Checks if current user has admin privileges
    private function checkAdmin(): void
    {
        if (
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role'] !== 'admin'
        ) {
            // Redirect non-admin users to public area
            header('Location: ' . APP_URL);
            exit;
        }
    }

    // Displays paginated and filtered list of users
    public function index(): void
    {
        $this->checkAdmin();

        // Collect filter and sorting parameters from URL
        $filters = [
            'search' => $_GET['search'] ?? '',
            'role'   => $_GET['role'] ?? '',
            'active' => $_GET['active'] ?? '',
            'sort'   => $_GET['sort'] ?? 'name',
            'dir'    => $_GET['dir'] ?? 'asc'
        ];

        // Pagination configuration
        $perPage = 10;
        $page = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * $perPage;

        // Get total users and calculate total pages
        $totalUsers = User::countAll($filters);
        $totalPages = (int)ceil($totalUsers / $perPage);

        // Retrieve filtered users
        $users = User::getAll($filters, $perPage, $offset);

        require_once __DIR__ . '/../views/admin/users/index.php';
    }

    // Activates or deactivates a user account
    public function toggle(): void
    {
        $this->checkAdmin();

        // Get user id and requested action
        $userId = (int)($_GET['id'] ?? 0);
        $action = $_GET['action_type'] ?? '';

        // Validate action and user id
        if (!$userId || !in_array($action, ['activate', 'deactivate'])) {
            header('Location: ' . APP_URL . '?controller=adminUser&action=index');
            exit;
        }

        // Basic protection: prevent admin from disabling own account
        if ($userId === $_SESSION['user']['id']) {
            setFlash('danger', 'No puedes desactivar tu propio usuario.');
            header('Location: ' . APP_URL . '?controller=adminUser&action=index');
            exit;
        }

        // Update user active status
        User::setActive($userId, $action === 'activate');

        // Store success message
        setFlash(
            'success',
            $action === 'activate'
                ? 'Usuario activado correctamente.'
                : 'Usuario desactivado correctamente.'
        );

        header('Location: ' . APP_URL . '?controller=adminUser&action=index');
        exit;
    }

    // Loads user edit form
    public function edit(): void
    {
        $this->checkAdmin();

        // Get user id from URL
        $userId = (int)($_GET['id'] ?? 0);
        $user = User::findById($userId);

        // If user does not exist, redirect with error
        if (!$user) {
            setFlash('danger', 'Usuario no encontrado.');
            header('Location: ' . APP_URL . '?controller=adminUser&action=index');
            exit;
        }

        // Load available roles
        $roles = Role::getAll();

        require_once __DIR__ . '/../views/admin/users/edit.php';
    }

    // Updates user data
    public function update(): void
    {
        $this->checkAdmin();

        // Get user id from POST data
        $userId = (int)($_POST['id'] ?? 0);

        if (!$userId) {
            header('Location: ' . APP_URL . '?controller=adminUser&action=index');
            exit;
        }

        // Protection: prevent admin from changing own role
        if ($userId === $_SESSION['user']['id']) {
            $_POST['role_id'] = $_SESSION['user']['role_id'];
        }

        // Update user information
        User::updateUser($userId, [
            'full_name' => $_POST['full_name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'] ?? null,
            'level' => (int)($_POST['level'] ?? 1),
            'role_id' => (int)$_POST['role_id'],
            'active' => isset($_POST['active']) ? 1 : 0
        ]);

        setFlash('success', 'Usuario actualizado correctamente.');

        header('Location: ' . APP_URL . '?controller=adminUser&action=index');
        exit;
    }

    // Loads user creation form
    public function create(): void
    {
        $this->checkAdmin();

        // Retrieve available roles
        $roles = Role::getAll();

        require_once __DIR__ . '/../views/admin/users/create.php';
    }

    // Stores a new user in database
    public function store(): void
    {
        $this->checkAdmin();

        // Ensure request method is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . APP_URL . '?controller=adminUser&action=index');
            exit;
        }

        // Generate initial password for new user
        $passwordPlain = '1234'; 
        $passwordHash = password_hash($passwordPlain, PASSWORD_DEFAULT);

        // Create new user record
        User::create([
            'full_name' => $_POST['full_name'],
            'email'     => $_POST['email'],
            'password'  => $passwordHash,
            'role_id'   => (int)$_POST['role_id'],
            'phone'     => $_POST['phone'] ?? null,
            'level'     => (int)($_POST['level'] ?? 1),
            'active'    => isset($_POST['active']) ? 1 : 0
        ]);

        // Store success message with initial password
        setFlash(
            'success',
            'Usuario creado correctamente. Contraseña inicial: 1234'
        );

        header('Location: ' . APP_URL . '?controller=adminUser&action=index');
        exit;
    }
}

