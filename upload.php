<?php
require_once("templates/bootstrap.php");

$stato_inserimento = "form";
$errore_msg = "";

// Controlla se l'utente ha premuto il tasto "Invia"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $categoria = $_POST["categoria"];
    $luogo = $_POST["luogo"];
    $data = $_POST["data"];
    $id_inseritore = $_SESSION["user_id"];
    
    // Gestione Immagine
    $nome_foto = null;
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $nome_foto = time() . "_" . basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $nome_foto;

        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $stato_inserimento = "errore";
            $errore_msg = "Errore nel caricamento fisico della foto.";
        }
    }

    // Salvataggio nel DB (se non ci sono errori precedenti)
    if ($stato_inserimento != "errore") {
        $successo = $db_obj->insertOggetto($nome, $categoria, $luogo, $data, $nome_foto, $id_inseritore);
        if ($successo) {
            $stato_inserimento = "successo";
        } else {
            $stato_inserimento = "errore";
            $errore_msg = "Errore nel database. Controlla la query.";
        }
    }
}

$templateParams["titolo"] = "Lost and Found - Upload";
$templateParams["nome"] = "components/upload-form.php";
$templateParams["stato_inserimento"] = $stato_inserimento; // Passiamo lo stato
$templateParams["errore_msg"] = $errore_msg;             // Passiamo l'errore

require_once("templates/base.php");
?>