<?php
require_once(__DIR__ . "/templates/bootstrap.php");
require_once(__DIR__ . "/utils/functions.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}

$claimId = isset($_POST['claim_id']) ? (int)$_POST['claim_id'] : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($claimId <= 0 || !in_array($action, ['accept', 'reject'])) {
    header("Location: my-reports.php?error=invalid_data");
    exit;
}

$claimInfo = $db_obj->isUserAuthorizedForClaim($claimId, $_SESSION['user_id']);

if (!$claimInfo) {
    header("Location: my-reports.php?error=unauthorized");
    exit;
}

$objectId = $claimInfo['oggetto_id'];
$success = false;

if ($action === 'accept') {
    $success = $db_obj->acceptClaim($claimId, $objectId);
} else {
    $success = $db_obj->rejectClaim($claimId);
}

if ($success) {
    header("Location: my-reports.php?success=1&action=" . $action);
} else {
    header("Location: my-reports.php?error=db_error");
}
exit;
?>