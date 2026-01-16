<?php
require_once(__DIR__ . "/templates/bootstrap.php"); // avvia sessione e inizializza $db_obj
require_once(__DIR__ . "/utils/functions.php");

// Solo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Utente deve essere loggato
if (!isUserLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Recupera object_id e optional message
$objectId = isset($_POST['object_id']) ? (int)$_POST['object_id'] : 0;
$message = isset($_POST['message']) ? trim($_POST['message']) : 'Richiesta da utente.';

if ($objectId <= 0) {
    $back = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header("Location: {$back}?error=invalid_object");
    exit;
}

// Salva la richiesta semplice (assume che $db_obj->createClaimRequest esista)
$db_obj->createClaimRequest($objectId, (int)$_SESSION['user_id'], $message);

// Torna alla pagina precedente (referer) o a index.php con messaggio di successo
$back = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header("Location: {$back}?msg=request_sent");
exit;
?>