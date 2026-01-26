<?php

// Model responsible for user data management and authentication
class User
{
    // Finds an active user by email (used for login)
    public static function findByEmail(string $email): ?array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT users.*, roles.name AS role_name
             FROM users
             JOIN roles ON users.role_id = roles.id
             WHERE email = :email AND active = 1"
        );

        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    // Retrieves all users with filters, sorting and pagination
    public static function getAll(array $filters = [], int $limit = 10, int $offset = 0): array
    {
        $db = Database::getConnection();

        // Allowed columns for safe sorting
        $allowedSorts = [
            'name'  => 'users.full_name',
            'email' => 'users.email',
            'level' => 'users.level',
            'role'  => 'roles.name',
            'active' => 'users.active'
        ];

        $sort = $allowedSorts[$filters['sort'] ?? 'name'] ?? 'users.full_name';
        $dir  = ($filters['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

        // Base query
        $sql = "
        SELECT
            users.id,
            users.full_name,
            users.email,
            users.phone,
            users.level,
            users.active,
            roles.name AS role
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE 1=1
    ";

        $params = [];

        // Apply search filter
        if (!empty($filters['search'])) {
            $sql .= " AND (users.full_name LIKE :search OR users.email LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        // Apply role filter
        if (!empty($filters['role'])) {
            $sql .= " AND roles.name = :role";
            $params['role'] = $filters['role'];
        }

        // Apply active status filter
        if (isset($filters['active']) && $filters['active'] !== '') {
            $sql .= " AND users.active = :active";
            $params['active'] = (int)$filters['active'];
        }

        // Add sorting and pagination
        $sql .= " ORDER BY $sort $dir";
        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $db->prepare($sql);

        // Bind dynamic parameters
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        // Bind pagination values
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Activates or deactivates a user account
    public static function setActive(int $userId, bool $active): void
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "UPDATE users SET active = :active WHERE id = :id"
        );

        $stmt->execute([
            'active' => $active ? 1 : 0,
            'id' => $userId
        ]);
    }

    // Finds a user by id
    public static function findById(int $id): ?array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
        SELECT users.*, roles.name AS role_name
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE users.id = :id
    ");

        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    // Updates user profile data
    public static function updateUser(int $id, array $data): void
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
        UPDATE users
        SET full_name = :full_name,
            email = :email,
            phone = :phone,
            level = :level,
            role_id = :role_id,
            active = :active
        WHERE id = :id
    ");

        $stmt->execute([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'level' => $data['level'],
            'role_id' => $data['role_id'],
            'active' => $data['active'],
            'id' => $id
        ]);
    }

    // Counts total users applying filters (used for pagination)
    public static function countAll(array $filters = []): int
    {
        $db = Database::getConnection();

        $sql = "
        SELECT COUNT(*) 
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE 1=1
    ";

        $params = [];

        // Apply same filters as listing
        if (!empty($filters['search'])) {
            $sql .= " AND (users.full_name LIKE :search OR users.email LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['role'])) {
            $sql .= " AND roles.name = :role";
            $params['role'] = $filters['role'];
        }

        if (isset($filters['active']) && $filters['active'] !== '') {
            $sql .= " AND users.active = :active";
            $params['active'] = (int)$filters['active'];
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn();
    }

    // Creates a new user account
    public static function create(array $data): void
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "INSERT INTO users (full_name, email, password_hash, role_id, phone, level, active)
             VALUES (:full_name, :email, :password_hash, :role_id, :phone, :level, :active)"
        );

        $stmt->execute([
            'full_name'     => $data['full_name'],
            'email'         => $data['email'],
            'password_hash' => $data['password'],
            'role_id'       => $data['role_id'],
            'phone'         => $data['phone'],
            'level'         => $data['level'],
            'active'        => $data['active']
        ]);
    }

    // Updates user password hash
    public static function updatePassword(int $id, string $hash): void
    {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "UPDATE users SET password_hash = :hash WHERE id = :id"
        );

        $stmt->execute([
            'hash' => $hash,
            'id'   => $id
        ]);
    }
}

