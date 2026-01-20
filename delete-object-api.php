<?php
require_once("templates/bootstrap.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $objectId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $source = isset($_POST['source']) ? $_POST['source'] : 'my-reports'; 

    if ($objectId > 0) {
        $userId = $_SESSION['user_id'];
        $isAdmin = ($_SESSION['ruolo'] === 'admin');

        if ($db_obj->deleteReport($objectId, $userId, $isAdmin)) {

            if ($source === 'search') {
                header("Location: search-objects.php?deleted=1");
            } else {
                header("Location: my-reports.php?deleted=1");
            }
            
        } else {
            $redirect = ($source === 'search') ? "search-objects.php" : "my-reports.php";
            header("Location: $redirect?error=delete_failed");
        }
    } else {
        header("Location: my-reports.php");
    }
}
exit();
?>