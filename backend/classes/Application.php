<?php
class Application {
    public static function create(int $userId, array $d): int {
        $st = Database::pdo()->prepare(
            'INSERT INTO applications
             (user_id, pet_name, species, service, appointment_datetime, payment_method_id, status_id)
             VALUES (?, ?, ?, ?, ?, ?, (SELECT id FROM statuses WHERE name = ?))'
        );
        $st->execute([
            $userId,
            $d['pet_name'],
            $d['species'],
            $d['service'],
            $d['appointment_datetime'],
            $d['payment_method_id'],
            'Новая',
        ]);
        return (int)Database::pdo()->lastInsertId();
    }

    public static function forUser(int $userId): array {
        $st = Database::pdo()->prepare(
            'SELECT a.*, s.name AS status_name, p.name AS payment_name
             FROM applications a
             JOIN statuses s ON s.id = a.status_id
             JOIN payment_methods p ON p.id = a.payment_method_id
             WHERE a.user_id = ?
             ORDER BY a.id DESC'
        );
        $st->execute([$userId]);
        return $st->fetchAll();
    }

        public static function all(array $filters = [], int $limit = 5, int $offset = 0): array {
        $sql = 'SELECT a.*, s.name AS status_name, p.name AS payment_name, u.full_name AS owner_name
                FROM applications a
                JOIN statuses s ON s.id = a.status_id
                JOIN payment_methods p ON p.id = a.payment_method_id
                JOIN users u ON u.id = a.user_id
                WHERE 1=1';
        $params = [];

        if (!empty($filters['status_id'])) {
            $sql .= ' AND a.status_id = ?';
            $params[] = $filters['status_id'];
        }
        if (!empty($filters['service'])) {
            $sql .= ' AND a.service = ?';
            $params[] = $filters['service'];
        }
        if (!empty($filters['search'])) {
            $sql .= ' AND (a.pet_name LIKE ? OR u.full_name LIKE ?)';
            $params[] = '%' . $filters['search'] . '%';
            $params[] = '%' . $filters['search'] . '%';
        }

        $sql .= ' ORDER BY a.id DESC LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset;

        $st = Database::pdo()->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    public static function countAll(array $filters = []): int {
        $sql = 'SELECT COUNT(*) FROM applications a JOIN users u ON u.id = a.user_id WHERE 1=1';
        $params = [];

        if (!empty($filters['status_id'])) {
            $sql .= ' AND a.status_id = ?';
            $params[] = $filters['status_id'];
        }
        if (!empty($filters['service'])) {
            $sql .= ' AND a.service = ?';
            $params[] = $filters['service'];
        }
        if (!empty($filters['search'])) {
            $sql .= ' AND (a.pet_name LIKE ? OR u.full_name LIKE ?)';
            $params[] = '%' . $filters['search'] . '%';
            $params[] = '%' . $filters['search'] . '%';
        }

        $st = Database::pdo()->prepare($sql);
        $st->execute($params);
        return (int)$st->fetchColumn();
    }

    public static function find(int $id): ?array {
        $st = Database::pdo()->prepare('SELECT * FROM applications WHERE id = ?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public static function statusName(int $id): ?string {
        $st = Database::pdo()->prepare(
            'SELECT s.name FROM applications a JOIN statuses s ON s.id = a.status_id WHERE a.id = ?'
        );
        $st->execute([$id]);
        $v = $st->fetchColumn();
        return $v === false ? null : $v;
    }

    public static function updateStatus(int $id, int $statusId): void {
        $st = Database::pdo()->prepare('UPDATE applications SET status_id = ? WHERE id = ?');
        $st->execute([$statusId, $id]);
    }
}