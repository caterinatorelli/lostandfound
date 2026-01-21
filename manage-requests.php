<?php
    require_once("templates/bootstrap.php");

    if (isset($_GET['action-error'])) {
        $errore = 'Errore nella richiesta';
    }

    $templateParams["titolo"] = "Lost and Found - Manage requests";
    $templateParams["nome"] = "components/admin-requests.php";

    require_once("templates/base.php");
?>