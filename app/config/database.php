<?php

// Database connection handler using PDO and Singleton pattern
class Database
{
    // Stores the single PDO connection instance
    private static ?PDO $connection = null;

    // Returns a shared PDO connection
    public static function getConnection(): PDO
    {
        // Create connection only once
        if (self::$connection === null) {
            // Data Source Name with charset configuration
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

            // Initialize PDO connection with error handling options
            self::$connection = new PDO(
                $dsn,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Fetch results as associative arrays
                ]
            );
        }

        // Return existing connection
        return self::$connection;
    }
}


