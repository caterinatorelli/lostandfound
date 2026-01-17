<?php 
    if (str_contains($templateParams["nome"], "admin")) {
        enforceAdmin();
    }
?>

<!DOCTYPE html>

<!-- Codice HTML della struttura principale della pagina, contenente navbar e footer -->

<html lang="it">
    <head>
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
       <link rel="stylesheet" href="css/style.css">
       <title> <?php echo $templateParams["titolo"] ?> </title>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="img/lostandfound.png" alt="Lost and found" width="60" height="60">
                    Lost and Found
                </a>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <?php if(!isset($_SESSION["user_id"])): ?>
                            <a class="nav-link active" href="login.php">Login</a>
                        <?php else: ?>
                            <a class="nav-link active" href="login-api.php">Logout</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="flex-grow-1 d-flex align-items-center">
            <div class="container">
                <?php
                    if(isset($templateParams["nome"])) {
                        require($templateParams["nome"]);
                    }
                ?>
            </div>
        </main>
        
        <footer class="py-3 mt-4 border-top text-center text-muted bg-secondary-subtle">
            Progetto finale corso di Tecnologie Web - AA 2025/2026
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>