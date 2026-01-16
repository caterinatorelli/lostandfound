<?php
    require_once("templates/bootstrap.php");

    if (isUserLoggedIn()) {
        destroySession();
        header("Location: index.php");
        exit();
    }

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $user = $db_obj->checkLogin($_POST["username"], $_POST["password"]);

        if (!empty($user)) {
            regiserLoggedUser($user);
        }
    }

    if (isUserLoggedIn()) {
        //header("Location: index.php");
    } else {
        //header("Location: login.php?error");
    }
?>