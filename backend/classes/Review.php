<?php
class Review {
    public static function create(int $applicationId, int $userId, string $text): void {
        $st = Database::pdo()->prepare(
            'INSERT INTO reviews (application_id, user_id, text) VALUES (?, ?, ?)'
        );
        $st->execute([$applicationId, $userId, $text]);
    }
    public static function forUser(int $userId): array {
        $st = Database::pdo()->prepare('SELECT * FROM reviews WHERE user_id = ?');
        $st->execute([$userId]);
        return $st->fetchAll();
    }
}