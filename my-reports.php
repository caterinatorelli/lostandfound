<?php
require_once("templates/bootstrap.php");

$templateParams["titolo"] = "Lost and Found - Mie Segnalazioni";
$templateParams["nome"] = "components/reports-form.php";

require_once(__DIR__ . "/utils/functions.php");

$userId = $_SESSION['user_id'] ?? 0;
$reports = $db_obj->getUserReports($userId);

require_once("templates/base.php");
?>