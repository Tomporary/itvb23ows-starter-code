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

    function getState() {
        return serialize([$_SESSION['hand'], $_SESSION['board'], $_SESSION['player']]);
    }

    function setState($state) {
        list($a, $b, $c) = unserialize($state);
        $_SESSION['hand'] = $a;
        $_SESSION['board'] = $b;
        $_SESSION['player'] = $c;
    }

    function getConnection()
    {
        return $this->connection;
    }
}
