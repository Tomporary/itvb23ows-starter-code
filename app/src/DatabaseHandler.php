<?php

namespace main;

use mysqli;

class DatabaseHandler
{
    private mysqli $connection;

    public function __construct()
    {
        $this->connection = new mysqli('db', 'root', '', 'hive');
    }

    public function getState() {
        return serialize([$_SESSION['hand'], $_SESSION['board'], $_SESSION['player']]);
    }

    public function setState($state) {
        list($a, $b, $c) = unserialize($state);
        $_SESSION['hand'] = $a;
        $_SESSION['board'] = $b;
        $_SESSION['player'] = $c;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
