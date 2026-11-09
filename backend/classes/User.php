<?php
class User {
    public static function create(array $d): int {
        $st = Database::pdo()->prepare(
            'INSERT INTO users (login, password_hash, full_name, phone, email) VALUES (?, ?, ?, ?, ?)'
        );
        $st->execute([
            $d['login'],
            password_hash($d['password'], PASSWORD_DEFAULT),
            $d['full_name'],
            $d['phone'],
            $d['email'],
        ]);
        return (int)Database::pdo()->lastInsertId();
    }
    public static function findByLogin(string $login): ?array {
        $st = Database::pdo()->prepare('SELECT * FROM users WHERE login = ?');
        $st->execute([$login]);
        return $st->fetch() ?: null;
    }
    public static function exists(string $login): bool {
        return self::findByLogin($login) !== null;
    }
}