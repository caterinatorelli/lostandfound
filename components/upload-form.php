<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <?php if ($stato_inserimento == "form"): ?>
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h1 class="h4 mb-0">Segnala Oggetto Trovato</h1>
                    </div>
                    <div class="card-body p-4">
                        <form action="upload.php" method="POST" enctype="multipart/form-data">
                            
                            <div class="mb-3">
                                <label for="nome" class="form-label fw-bold">Cosa hai trovato?</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Es: Zaino, Smartphone..." required>
                            </div>

                            <div class="mb-3">
                                <label for="categoria" class="form-label fw-bold">Categoria</label>
                                <select class="form-select" id="categoria" name="categoria" required>
                                    <option value="" selected disabled>Scegli una categoria...</option>
                                    <option value="Elettronica">Elettronica</option>
                                    <option value="Vestiti">Vestiti</option>
                                    <option value="Materiale scolastico">Materiale scolastico</option>
                                    <option value="Altro">Altro</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="luogo" class="form-label fw-bold">Luogo</label>
                                <input type="text" class="form-control" id="luogo" name="luogo" placeholder="Es: Aula 3, Biblioteca..." required>
                            </div>

                            <div class="mb-3">
                                <label for="data" class="form-label fw-bold">Data ritrovamento</label>
                                <input type="date" class="form-control" id="data" name="data" required>
                            </div>

                            <div class="mb-4">
                                <label for="foto" class="form-label fw-bold text-primary">Carica una foto</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*" aria-describedby="fotoHelp">
                                <small id="fotoHelp" class="text-muted">La foto sarà salvata nella cartella 'uploads' del server.</small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Registra Oggetto</button>
                            </div>
                        </form>
                    </div>
                </div>

            <?php elseif ($stato_inserimento == "successo"): ?>
                <div class="card shadow text-center p-5">
                    <i class="bi bi-check-circle-fill success-icon mb-3" aria-hidden="true"></i>
                    <h2 class="text-success">Ottimo lavoro!</h2>
                    <p class="mb-4">L'oggetto e la foto sono stati correttamente salvati.</p>
                    <div class="d-grid gap-2">
                        <a href="upload.php" class="btn btn-primary">Inserisci un altro</a>
                        <a href="search-objects.php" class="btn btn-outline-secondary">Vai alla lista oggetti</a>
                    </div>
                </div>

            <?php else: ?>
                <div class="alert alert-danger shadow" role="alert">
                    <h4 class="alert-heading"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i> Errore!</h4>
                    <p><?php echo $errore_msg; ?></p>
                    <hr>
                    <a href="upload.php" class="btn btn-danger">Riprova</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>