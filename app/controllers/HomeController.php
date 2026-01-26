<?php

// Controller for public home page
class HomeController
{
    // Loads the main home view
    public function index(): void
    {
        require_once __DIR__ . '/../views/home/index.php';
    }
}


