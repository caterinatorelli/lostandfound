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

$claimId = isset($_POST['claim_id']) ? (int)$_POST['claim_id'] : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($claimId <= 0 || !in_array($action, ['accept', 'reject'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Dati non validi']);
    exit;
}

$query = "SELECT r.id, o.id as oggetto_id 
          FROM richieste r
          JOIN oggetti_ritrovati o ON r.oggetto_id = o.id
          WHERE r.id = ? AND o.id_inseritore = ?";
$stmt = $db_obj->db->prepare($query);
$stmt->bind_param("ii", $claimId, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Non autorizzato o richiesta inesistente']);
    exit;
}

$row = $result->fetch_assoc();
$objectId = $row['oggetto_id'];
$success = false;

if ($action === 'accept') {
    $success = $db_obj->acceptClaim($claimId, $objectId);
} else {
    $success = $db_obj->rejectClaim($claimId);
}

if ($success) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Errore nell\'aggiornamento del database']);
}
exit;
?>