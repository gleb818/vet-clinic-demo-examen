<?php
class Database {
    private static ?PDO $pdo = null;

    public static function pdo(): PDO {
        if (self::$pdo === null) {
            $c = require __DIR__ . '/../config.php';
            $dbPath = $c['db']['path'];
            $isNew = !file_exists($dbPath);

            self::$pdo = new PDO('sqlite:' . $dbPath, null, null, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            if ($isNew) {
                $schema = file_get_contents(__DIR__ . '/../database/schema.sql');
                self::$pdo->exec($schema);
            }
        }
        return self::$pdo;
    }
}