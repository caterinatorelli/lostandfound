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

if (!$db_obj->isUserAuthorizedForClaim($claimId, (int)$_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Non autorizzato']);
    exit;
}

$status = $action === 'accept' ? 'accettata' : 'rifiutata';
$success = $db_obj->updateClaimStatus($claimId, $status);

if ($success) {
    if ($action === 'accept') {
        // Get objectId from claim
        $query = "SELECT oggetto_id FROM richieste WHERE id = ?";
        $stmt = $db_obj->db->prepare($query);
        $stmt->bind_param("i", $claimId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $objectId = $row['oggetto_id'];
            $db_obj->updateObjectStatus($objectId, 'returned');
        }
    }
    // Redirect back with success
    header("Location: my-reports.php?success=1&action=" . $action . "&claim_id=" . $claimId);
    exit;
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Errore nell\'aggiornamento']);
}
exit;
?>