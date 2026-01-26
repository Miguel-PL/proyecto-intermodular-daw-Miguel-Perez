<?php
// Start user session
session_start();

// Load global configuration and database connection
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/config/database.php';

// Default controller and action
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Build controller class name and file path
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

// Check if controller file exists
if (!file_exists($controllerFile)) {
    die('Controller not found');
}

// Load controller class
require_once $controllerFile;

// Create controller instance
$controllerObject = new $controllerName();

// Check if requested action exists
if (!method_exists($controllerObject, $action)) {
    die('Action not found');
}

// Execute controller action
$controllerObject->$action();

