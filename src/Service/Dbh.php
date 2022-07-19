<?php

namespace RaceTracker\Service;

use mysqli;
use PDO;
require_once 'app/config/loadenv.php';

class Dbh
{
    protected function connect()
    {
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'];
        $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PWD']);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }

    protected function mysqli()
    {
        $mysqli = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PWD'], $_ENV['DB_NAME']);
        return $mysqli;
    }
}