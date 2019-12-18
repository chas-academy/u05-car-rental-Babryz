<?php

    namespace Main\core;

    function login() {
        $hostname = "localhost";
        $database = "carRental";
        $username = "root";
        $password = "secret";

        $connection = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
        if (!$connection) die($connection->errorInfo() [2]);
        return $connection;
    }
?>