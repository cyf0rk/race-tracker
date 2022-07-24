<?php

namespace RaceTracker\Model;

use mysqli;
use PDO;
require_once 'config/loadenv.php';

/**
 * Database handler class
 */
class Dbh
{
    protected function connect()
    {
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'];
        $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PWD']);
        $pdo->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::FETCH_ASSOC);

        return $pdo;
    }

    protected function mysqli()
    {
        $mysqli = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PWD'], $_ENV['DB_NAME']);

        if ($mysqli->connect_errno) {
            printf("Connect failed: %s\n", $mysqli->connect_error);
            exit();
        }

        return $mysqli;
    }
}