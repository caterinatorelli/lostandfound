<?php
    require_once(__DIR__ . "/templates/bootstrap.php"); // avvia sessione e inizializza $db_obj
    require_once(__DIR__ . "/utils/functions.php");

    header('Content-Type: application/json');

    // Solo POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Metodo non permesso']);
        exit;
    }

    // Utente deve essere loggato
    if (!isUserLoggedIn()) {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Utente non loggato']);
        exit;
    }

    // Recupera object_id e optional message
    $objectId = isset($_POST['object_id']) ? (int)$_POST['object_id'] : 0;
    $message = isset($_POST['message']) ? trim($_POST['message']) : 'Richiesta da utente.';

    if ($objectId <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'ID oggetto non valido']);
        exit;
    }

    // Salva la richiesta semplice (assume che $db_obj->createClaimRequest esista)
    $result = $db_obj->createClaimRequest($objectId, (int)$_SESSION['user_id'], $message);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Errore nel salvataggio']);
    }
    exit;
?>