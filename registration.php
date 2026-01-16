<?php
require_once 'database.php'; 
$messaggio = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password_sicura = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO utenti (email, password, ruolo) VALUES (?, ?, 'fruitore')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password_sicura);

    if ($stmt->execute()) {
        // Aggiunto ruolo 'status' per avvisare gli screen reader del cambiamento
        $messaggio = "<div class='alert alert-success' role='status'>Registrazione completata! <a href='login.php'>Vai al login</a></div>";
    } else {
        $messaggio = "<div class='alert alert-danger' role='alert'>Errore durante la registrazione (Email già presente?).</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione - Lost & Found Campus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Miglioramento del contrasto per l'accessibilità  */
        .form-label { font-weight: 600; }
        :focus { outline: 3px solid #0d6efd; border-radius: 4px; }
    </style>
</head>
<body class="bg-light d-flex align-items-center vh-100">
    <main class="container"> <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow p-4">
                    <h1 class="text-center h3 mb-4">Crea un account</h1>
                    
                    <?php if ($messaggio): echo $messaggio; endif; ?>

                    <form action="registration.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Universitaria</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="form-control" 
                                   required 
                                   aria-required="true"
                                   placeholder="esempio@studenti.unibo.it"
                                   autocomplete="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-control" 
                                   required 
                                   aria-required="true"
                                   autocomplete="new-password">
                        </div>
                        <button type="submit" name="register" class="btn btn-primary w-100 py-2">
                            Registrati
                        </button>
                    </form>
                    
                    <footer class="mt-4 text-center">
                        <p class="small text-muted">
                            Hai già un account? <a href="login.php" aria-label="Vai alla pagina di login">Accedi qui</a>
                        </p>
                    </footer>
                </div>
            </div>
        </div>
    </main>
</body>
</html>