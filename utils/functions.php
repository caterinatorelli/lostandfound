<?php
    // File contenente funzioni di supporto al programma

    /**
     * Checks if the user is currently logged int
     * @return bool `true` if the user is logged in, `false` otherwise
     */
    function isUserLoggedIn(): bool {
        return !empty($_SESSION["user_id"]);
    }

    /**
     * Registers current user session information
     * @param array $user user's data
     */
    function regiserLoggedUser(array $user): void {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["email"];
        $_SESSION["ruolo"] = $user["ruolo"];
    }

    /**
     * Used to destroy user's session data and cookie for logout purposes
     */
    function destroySession(): void {
        $_SESSION = array();
        setcookie(session_name(), "", time() - 3600);
        session_destroy();
    }

    /**
     * Checks if the user has admin privileges. Used to protect admin only pages
     */
    function enforceAdmin(): void {
        if (!isUserLoggedIn() || $_SESSION["ruolo"] != "admin") {
            header("HTTP/1.1 403 Forbidden");
            echo "You can't access this page";
            exit();
        }
    }
?>