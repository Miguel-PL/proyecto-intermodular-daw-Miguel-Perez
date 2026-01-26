<?php

// Model responsible for role data retrieval
class Role
{
    // Retrieves all available roles
    public static function getAll(): array
    {
        $db = Database::getConnection();

        $stmt = $db->query("SELECT id, name FROM roles");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

