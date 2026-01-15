<?php
$host = "localhost";
$user = "root"; // Utente di default in locale (XAMPP/MAMP)
$password = ""; // Password di default (spesso vuota)
$dbname = "campus_oggetti_smarriti";

// Connessione con l'estensione MySQLi
$conn = new mysqli($host, $user, $password, $dbname);

// Controllo connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>