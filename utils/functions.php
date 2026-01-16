<?php
    function isUserLoggedIn() {
        return !empty($_SESSION["user_id"]);
    }

    function regiserLoggedUser(array $user): void {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["nome"] = $user["nome"];
    }

    function destroySession() {
        $_SESSION = array();
        setcookie(session_name(), "", time() - 3600);
        session_destroy();
    }
?>