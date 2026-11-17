<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

/** Fournit une seule connexion PDO partagée par toute l'application. */
class Database
{
    private static ?PDO $pdo = null;

    /** @var array{host: string, port: int, name: string, user: string, password: string} */
    private static array $config;

    public static function configure(array $config): void
    {
        self::$config = $config;
        self::$pdo = null;
    }

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $c = self::$config;
            $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $c['host'], $c['port'], $c['name']);
            self::$pdo = new PDO($dsn, $c['user'], $c['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }
        return self::$pdo;
    }
}
