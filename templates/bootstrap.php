<?php
    session_start();

    require_once("utils/functions.php");
    require_once("db/database.php");

    $db_obj = new Database("localhost", "root", "", "campus_oggetti_smarriti", 3306);
?>