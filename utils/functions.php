<?php
    // File contenente funzioni di supporto al programma

    function isUserLoggedIn(): bool {
        return !empty($_SESSION["user_id"]);
    }

    function regiserLoggedUser(array $user): void {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["email"];
        $_SESSION["ruolo"] = $user["ruolo"];
    }

    function destroySession() {
        $_SESSION = array();
        setcookie(session_name(), "", time() - 3600);
        session_destroy();
    }
?>