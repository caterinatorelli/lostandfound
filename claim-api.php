<?php
    require_once(__DIR__ . "/templates/bootstrap.php");
    require_once(__DIR__ . "/utils/functions.php");

    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Metodo non permesso']);
        exit;
    }

    if (!isUserLoggedIn()) {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Utente non loggato']);
        exit;
    }

    $objectId = isset($_POST['object_id']) ? (int)$_POST['object_id'] : 0;
    $message = isset($_POST['message']) ? trim($_POST['message']) : 'Richiesta da utente.';

    if ($objectId <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'ID oggetto non valido']);
        exit;
    }

    $objects = $db_obj->getObject($objectId);
    if (empty($objects)) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Oggetto non trovato']);
        exit;
    }
    $object = $objects[0];

    if ($object['id_inseritore'] == $_SESSION['user_id']) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Non puoi rivendicare il tuo stesso oggetto']);
        exit;
    }

    if ($db_obj->hasPendingClaim($objectId, (int)$_SESSION['user_id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Hai già fatto richiesta per questo oggetto']);
        exit;
    }

    $result = $db_obj->createClaimRequest($objectId, (int)$_SESSION['user_id'], $message);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Errore nel salvataggio']);
    }
    exit;
?>