<?php
    require_once("templates/bootstrap.php");
    require_once("utils/functions.php");

    // Recupero dati e Calcoli (Logica identica a prima)
    $tuttiGliOggetti = $db_obj->getFoundObjects();
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