<?php
require_once("templates/bootstrap.php");

// 1. Inizializziamo le variabili che il template si aspetta
$stato_inserimento = "form";
$errore_msg = "";

// 2. LOGICA: Controlliamo se l'utente ha premuto il tasto "Invia"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $categoria = $_POST["categoria"];
    $luogo = $_POST["luogo"];
    $data = $_POST["data"];
    
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
        $successo = $db_obj->insertOggetto($nome, $categoria, $luogo, $data, $nome_foto);
        if ($successo) {
            $stato_inserimento = "successo";
        } else {
            $stato_inserimento = "errore";
            $errore_msg = "Errore nel database. Controlla la query.";
        }
    }
}

// 3. PASSAGGIO DATI AL TEMPLATE
// Dobbiamo rendere queste variabili disponibili dentro base.php e upload-form.php
$templateParams["titolo"] = "Lost and Found - Upload";
$templateParams["nome"] = "components/upload-form.php";
$templateParams["stato_inserimento"] = $stato_inserimento; // Passiamo lo stato
$templateParams["errore_msg"] = $errore_msg;             // Passiamo l'errore

require_once("templates/base.php");
?>