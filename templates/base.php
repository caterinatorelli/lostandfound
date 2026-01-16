<!DOCTYPE html>

<html lang="it">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <title> <?php echo $templateParams["titolo"] ?> </title>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <nav class=" navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Lost and Found</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php">
                            <?php if(!isset($_SESSION["user_id"])): ?>
                                Login
                            <?php else: ?>
                                Logout
                            <?php endif; ?>
                        </a>
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