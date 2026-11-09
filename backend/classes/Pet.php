<?php
class Pet {
    public static function add(int $userId, string $name, string $species): void {
        $st = Database::pdo()->prepare('INSERT INTO pets (user_id, name, species) VALUES (?, ?, ?)');
        $st->execute([$userId, $name, $species]);
    }

    public static function forUser(int $userId): array {
        $st = Database::pdo()->prepare('SELECT * FROM pets WHERE user_id = ? ORDER BY id DESC');
        $st->execute([$userId]);
        return $st->fetchAll();
    }

    public static function find(int $id): ?array {
        $st = Database::pdo()->prepare('SELECT * FROM pets WHERE id = ?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }
}