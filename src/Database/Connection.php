<?php

namespace App\Database;

use PDO;

class Connection
{
    public static function get(): PDO
    {
        $pdo = new PDO('sqlite:database.sqlite:' . __DIR__ . '/../database/app.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}