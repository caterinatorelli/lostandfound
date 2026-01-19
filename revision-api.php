<?php
    require_once("templates/bootstrap.php");

    enforceAdmin();

    if (!isset($_GET["m"]) || !isset($_GET["o"])) {
        header("Location: index.php");
        exit;
    }

    $action = $_GET["m"];
    $object = $_GET["o"];

    switch ($action) {
        case "a":
            $db_obj->approveRequest($object);
            break;
        case "d":
            $db_obj->denyRequest($object);
            break;
        default:
            header("Location: index.php");
        exit();
    }

    header("Location: manage-requests.php")
?>