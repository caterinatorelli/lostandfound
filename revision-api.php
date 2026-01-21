<?php
    require_once("templates/bootstrap.php");

    header('Content-Type: application/json');
    enforceAdmin();
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'wrong request type']);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data["approved"]) || !isset($data["objectID"])) {
        http_response_code(400);
        echo json_encode(["success"=> false,"message"=> "request body is not valid"]);
        exit;
    }

    $approved = $data['approved'];
    $objectID = $data['objectID'];

    if($approved) {
        $db_obj->approveRequest($objectID);
    } else {
        $db_obj->denyRequest($objectID);
    }

    http_response_code(200);
    echo json_encode(['success'=> true]);
?>