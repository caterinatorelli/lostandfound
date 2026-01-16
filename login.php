<?php
session_start(); // Inizia la sessione per ricordare l'utente
require_once 'database.php';

$errore = "";

if (isset($_POST['submit'])) {
    $email = $_POST['username']; // Usa l'email come username
    $password = $_POST['password'];

    // Cerca l'utente nel database
    $sql = "SELECT id, password, ruolo FROM utenti WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Verifichiamo la password criptata
        if (password_verify($password, $user['password'])) {
            // Salviamo i dati in sessione
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['ruolo'] = $user['ruolo'];

            // Reindirizzamento in base al ruolo
            if ($user['ruolo'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $errore = "Password errata.";
        }
    } else {
        $errore = "Utente non trovato.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Lost & Found - Registrazione</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="style.css">
</head>
</head>
<body class="bg-light d-flex align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
                <div class="card shadow p-4">
                    <h1 class="text-center h3 mb-4">Lost & Found Login</h1>
                    
                    <?php if($errore): ?>
                        <div class="alert alert-danger"><?php echo $errore; ?></div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Email Universitaria:</label>
                            <input type="text" id="username" name="username" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" required />
                        </div>
                        <div class="d-grid">
                            <input type="submit" name="submit" value="Accedi" class="btn btn-primary" />
                        </div>
                    </form>
                    <div class="mt-3 text-center">
                       <p>Non hai un account? <a href="registration.php" class="text-primary fw-bold">Registrati</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>