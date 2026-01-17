<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once("utils/functions.php");
    require_once("db/database.php");

    if (!isset($db_obj)) {
        $dbHost = 'localhost';
        $dbUser = 'root';
        $dbPass = '';
        $dbName = 'campus_oggetti_smarriti';
        $dbPort = 3306;

        $db_obj = new Database($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
    }
?>