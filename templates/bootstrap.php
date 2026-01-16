<?php
// Avvia sessione e fornisce $db_obj e il link al CSS (minimale, modifica credenziali DB se necessario)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// carica lo style del progetto
echo '<link rel="stylesheet" href="/css/style.css">' . PHP_EOL;

// Inizializza l'oggetto DB se non esiste già
if (!isset($db_obj)) {
    // include la classe Database (assume esiste c:\xampp\htdocs\lostandfound\db\database.php)
    require_once __DIR__ . '/../db/database.php';

    // Parametri di default per XAMPP locale; se il vostro team usa altri valori, cambiateli qui
    $dbHost = '127.0.0.1';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'campus_oggetti_smarriti';
    $dbPort = 3306;

    // Crea l'istanza (se la classe Database ha firma diversa, adattare)
    try {
        $db_obj = new Database($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
    } catch (Throwable $e) {
        // non interrompere con errore visibile al frontend: $db_obj rimane non settato
        $db_obj = null;
    }
}
?>