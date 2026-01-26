<?php

// Model responsible for reservation database operations and business rules
class Reservation
{
    // Retrieves all reservations for a specific user
    public static function getByUser(int $userId): array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT r.*, c.name AS court_name
             FROM reservations r
             JOIN courts c ON r.court_id = c.id
             WHERE r.user_id = :user_id
             ORDER BY r.start_datetime DESC"
        );

        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    // Checks if a court is available for a given time range
    public static function isAvailable(
        int $courtId,
        string $start,
        int $durationMinutes
    ): bool {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT COUNT(*) FROM reservations
             WHERE court_id = :court_id
               AND status = 'confirmed'
               AND (
                   start_datetime < DATE_ADD(:start, INTERVAL :duration MINUTE)
                   AND DATE_ADD(start_datetime, INTERVAL duration_minutes MINUTE) > :start
               )"
        );

        $stmt->execute([
            'court_id' => $courtId,
            'start' => $start,
            'duration' => $durationMinutes
        ]);

        // Available if no overlapping reservations exist
        return $stmt->fetchColumn() == 0;
    }

    // Creates a new reservation record
    public static function create(array $data): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "INSERT INTO reservations (user_id, court_id, start_datetime, duration_minutes)
             VALUES (:user_id, :court_id, :start_datetime, :duration_minutes)"
        );

        return $stmt->execute([
            'user_id' => $data['user_id'],
            'court_id' => $data['court_id'],
            'start_datetime' => $data['start_datetime'],
            'duration_minutes' => $data['duration_minutes']
        ]);
    }

    // Determines if a reservation can still be canceled
    public static function canCancel(array $reservation): bool
    {
        $now = new DateTime();
        $start = new DateTime($reservation['start_datetime']);

        // Calculate time difference in hours
        $diffHours = ($start->getTimestamp() - $now->getTimestamp()) / 3600;

        // Allow cancellation only if at least 2 hours remain
        return $diffHours >= 2;
    }

    // Cancels a reservation by updating its status
    public static function cancel(int $id): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "UPDATE reservations
             SET status = 'cancelled'
             WHERE id = :id"
        );

        return $stmt->execute(['id' => $id]);
    }

    // Retrieves all reservations (admin view)
    public static function getAll(): array
    {
        $db = Database::getConnection();

        $stmt = $db->query(
            "SELECT r.*, 
                    u.full_name AS user_name,
                    c.name AS court_name
             FROM reservations r
             JOIN users u ON r.user_id = u.id
             JOIN courts c ON r.court_id = c.id
             ORDER BY r.start_datetime DESC"
        );

        return $stmt->fetchAll();
    }

    // Retrieves reservations for a court on a specific date
    public static function getByCourtAndDate(int $courtId, string $date): array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT start_datetime, duration_minutes
             FROM reservations
             WHERE court_id = :court_id
               AND DATE(start_datetime) = :date
               AND status = 'confirmed'"
        );

        $stmt->execute([
            'court_id' => $courtId,
            'date' => $date
        ]);

        return $stmt->fetchAll();
    }

    // Updates reservation data
    public static function update(int $id, array $data): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "UPDATE reservations
             SET user_id = :user_id,
                 court_id = :court_id,
                 start_datetime = :start_datetime,
                 duration_minutes = :duration_minutes
             WHERE id = :id"
        );

        return $stmt->execute([
            'user_id' => $data['user_id'],
            'court_id' => $data['court_id'],
            'start_datetime' => $data['start_datetime'],
            'duration_minutes' => $data['duration_minutes'],
            'id' => $id
        ]);
    }

    // Finds a reservation by its id
    public static function find(int $id): ?array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT * FROM reservations WHERE id = :id"
        );

        $stmt->execute(['id' => $id]);

        $reservation = $stmt->fetch();

        return $reservation ?: null;
    }
}

