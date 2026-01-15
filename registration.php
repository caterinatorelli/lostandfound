<?php
require_once 'database.php'; 
$messaggio = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Criptazione obbligatoria per la sicurezza
    $password_sicura = password_hash($password, PASSWORD_DEFAULT);

    // Query preparata per evitare SQL Injection
    $sql = "INSERT INTO utenti (email, password, ruolo) VALUES (?, ?, 'fruitore')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password_sicura);

    if ($stmt->execute()) {
        $messaggio = "<div class='alert alert-success'>Registrazione completata! <a href='login.php'>Vai al login</a></div>";
    } else {
        $messaggio = "<div class='alert alert-danger'>Errore durante la registrazione (Email già presente?).</div>";
    }
}
?>
