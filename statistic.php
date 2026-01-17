<?php

session_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Controllo Database
if (!file_exists(__DIR__ . '/db/database.php')) {
    die("ERRORE: Non trovo il file database.php");
}
require_once __DIR__ . '/db/database.php'; 

// Connessione
try {
    $db = new Database("localhost", "root", "", "campus_oggetti_smarriti", 3306);
} catch (Exception $e) {
    die("Errore connessione DB: " . $e->getMessage());
}

// Recupero dati e Calcoli (Logica identica a prima)
$tuttiGliOggetti = $db->getFoundObjects();
if (!is_array($tuttiGliOggetti)) $tuttiGliOggetti = []; 

$conteggioLuoghi = [];
$conteggioCategorie = [];

foreach ($tuttiGliOggetti as $oggetto) {
    $luogo = $oggetto['luogo'] ?? 'Sconosciuto';
    $cat = $oggetto['categoria'] ?? 'Altro';

    $conteggioLuoghi[$luogo] = ($conteggioLuoghi[$luogo] ?? 0) + 1;
    $conteggioCategorie[$cat] = ($conteggioCategorie[$cat] ?? 0) + 1;
}

$datiLuoghi = [];
foreach ($conteggioLuoghi as $k => $v) $datiLuoghi[] = ['etichetta' => $k, 'totale' => $v];

$datiCategorie = [];
foreach ($conteggioCategorie as $k => $v) $datiCategorie[] = ['etichetta' => $k, 'totale' => $v];

$templateParams["titolo"] = "Statistiche - Lost and Found";

$templateParams["nome"] = "components/statistic-form.php"; 


require 'templates/base.php'; 
?>