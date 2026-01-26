<?php

// Model responsible for court (resource) database operations
class Court
{
    // Retrieves all courts ordered by name
    public static function getAll(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM courts ORDER BY name");
        return $stmt->fetchAll();
    }

    // Finds a court by its id
    public static function find(int $id): ?array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM courts WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $court = $stmt->fetch();
        return $court ?: null;
    }

    // Creates a new court record
    public static function create(array $data): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "INSERT INTO courts (name, description, max_players, image)
             VALUES (:name, :description, :max_players, :image)"
        );

        return $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'max_players' => $data['max_players'],
            'image' => $data['image']
        ]);
    }

    // Updates an existing court
    public static function update(int $id, array $data): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "UPDATE courts
             SET name = :name,
                 description = :description,
                 max_players = :max_players,
                 image = :image
             WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description'],
            'max_players' => $data['max_players'],
            'image' => $data['image']
        ]);
    }

    // Deletes a court by id
    public static function delete(int $id): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("DELETE FROM courts WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
