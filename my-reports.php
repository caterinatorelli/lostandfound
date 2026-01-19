<?php
require_once("templates/bootstrap.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

$templateParams["titolo"] = "Lost and Found - Mie Segnalazioni";
$templateParams["nome"] = "components/reports-form.php";

require_once(__DIR__ . "/utils/functions.php");

$userId = $_SESSION['user_id'];
$reports = $db_obj->getUserReports($userId);
$templateParams["reports"] = $reports;

// Handle success message
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $action = $_GET['action'] ?? '';
    $claimId = $_GET['claim_id'] ?? '';
    if ($action === 'accept') {
        $templateParams["message"] = "Richiesta accettata! L'oggetto è stato restituito.";
    } elseif ($action === 'reject') {
        $templateParams["message"] = "Richiesta rifiutata.";
    }
}

require_once("templates/base.php");
?>