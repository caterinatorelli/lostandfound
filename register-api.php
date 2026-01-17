<?php
    // Endpoint API per la creazione di un nuovo utente

    require_once("templates/bootstrap.php");

    if (isUserLoggedIn()) {
        header("Location: index.php");
        exit();
    }

    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $db_obj->registerUser($_POST["email"], $_POST["password"]);
        header("Location: login.php");
    } else {
        header("Location: register.php?error");
    }
?>