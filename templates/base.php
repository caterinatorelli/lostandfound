<?php 
    if (str_contains($templateParams["nome"], "admin")) {
        enforceAdmin();
    }
?>

<!DOCTYPE html>

<!-- Codice HTML della struttura principale della pagina, contenente navbar e footer -->

<html lang="it">
    <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
       <link rel="stylesheet" href="css/style.css">
       <title> <?php echo $templateParams["titolo"] ?> </title>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="img/lostandfound.png" alt="Lost and found" width="60" height="60">
                    Lost and Found
                </a>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <?php if (isUserLoggedIn()): ?>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="upload.php">Crea segnalazione</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="search-objects.php">Cerca oggetti</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="statistic.php">Statistiche</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $_SESSION["username"]; ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="my-reports.php">I tuoi report</a></li>
                                    <li><a class="dropdown-item" href="login-api.php">Logout</a></li>
                                    <?php if ($_SESSION["ruolo"] == 'admin'): ?>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="admin.php">Admin panel</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    <?php else: ?>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="login.php">Login</a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </body>
</html>