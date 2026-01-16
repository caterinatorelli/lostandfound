<?php
require_once 'database.php'; 

// Controllo se la connessione esiste
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Variabile per gestire lo stato della pagina
$stato_inserimento = "form"; 
$errore_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome      = $conn->real_escape_string($_POST['nome']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $luogo     = $conn->real_escape_string($_POST['luogo']);
    $data      = $conn->real_escape_string($_POST['data']);
    $nome_foto = NULL;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        
        $target_dir = "uploads/";
        
        if (!is_dir($target_dir)) { 
            mkdir($target_dir, 0777, true); 
        }

        $file_name = $_FILES["foto"]["name"];
        $estensione = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $nome_foto = time() . "_" . uniqid() . "." . $estensione; 
        $target_file = $target_dir . $nome_foto;

        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if($check !== false) {
            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $stato_inserimento = "errore";
                $errore_msg = "Impossibile salvare l'immagine nella cartella. Controlla i permessi di sistema.";
            }
        } else {
            $stato_inserimento = "errore";
            $errore_msg = "Il file caricato non è un'immagine valida.";
        }
    }

    // INSERIMENTO NEL DATABASE
    if ($stato_inserimento != "errore") {

        $sql = "INSERT INTO oggetti_ritrovati (nome, categoria, luogo, data_ritrovamento, foto) 
                VALUES ('$nome', '$categoria', '$luogo', '$data', '$nome_foto')";

        if ($conn->query($sql) === TRUE) {
            $stato_inserimento = "successo";
        } else {
            $stato_inserimento = "errore";
            $errore_msg = "Errore SQL: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Lost & Found - Registrazione</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"><style>
        .success-icon { font-size: 4rem; color: #198754; }
        .card { border-radius: 15px; border: none; }
        .btn-primary { border-radius: 8px; padding: 10px 20px; }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <?php if ($stato_inserimento == "form"): ?>
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h1 class="h4 mb-0">Segnala Oggetto Trovato</h1> <!--tratta il titolo come h1 ma lo fa vedere come h4 -->
                    </div>
                    <div class="card-body p-4">
                        <form action="inseriscioggetto.php" method="POST" enctype="multipart/form-data"> <!--Divide i dati in "parti" (multiple parts).
                            Invia il testo (nome, categoria) in un modo e i dati binari della foto in un altro, permettendo al server di ricostruire 
                            il file immagine correttamente.!-->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Cosa hai trovato?</label>
                                <input type="text" class="form-control" name="nome" placeholder="Es: Zaino, Smartphone..." required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Categoria</label>
                                <select class="form-select" name="categoria" required>
                                    <option value="" selected disabled>Scegli una categoria...</option>
                                    <option value="Elettronica">Elettronica</option>
                                    <option value="Vestiti">Vestiti</option>
                                    <option value="Materiale scolastico">Materiale scolastico</option>
                                    <option value="Altro">Altro</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Luogo</label>
                                <input type="text" class="form-control" name="luogo" placeholder="Es: Aula 3, Biblioteca..." required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Data ritrovamento</label>
                                <input type="date" class="form-control" name="data" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-primary">Carica una foto</label>
                                <input type="file" class="form-control" name="foto" accept="image/*">
                                <small class="text-muted">La foto sarà salvata nella cartella 'uploads' del server.</small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Registra Oggetto</button>
                            </div>
                        </form>
                    </div>
                </div>

            <?php elseif ($stato_inserimento == "successo"): ?>
                <div class="card shadow text-center p-5">
                    <i class="bi bi-check-circle-fill success-icon mb-3"></i>
                    <h2 class="text-success">Ottimo lavoro!</h2>
                    <p class="mb-4">L'oggetto e la foto sono stati correttamente salvati.</p>
                    <div class="d-grid gap-2">
                        <a href="inseriscioggetto.php" class="btn btn-primary">Inserisci un altro</a>
                        <a href="lista_oggetti.php" class="btn btn-outline-secondary">Vai alla lista oggetti</a>
                    </div>
                </div>

            <?php else: ?>
                <div class="alert alert-danger shadow" role="alert">
                    <h4 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Errore!</h4>
                    <p><?php echo $errore_msg; ?></p>
                    <hr>
                    <a href="inseriscioggetto.php" class="btn btn-danger">Riprova</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>