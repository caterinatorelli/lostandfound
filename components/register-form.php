<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow p-4">
            
            <?php if ($stato == "form"): ?>
                <h1 class="text-center h3 mb-4">Segnala Oggetto Trovato</h1>
                
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Cosa hai trovato?</label>
                        <input type="text" id="nome" name="nome" class="form-control" 
                               placeholder="Es: Zaino, Smartphone..." required aria-required="true">
                    </div>

                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <select id="categoria" name="categoria" class="form-select" required aria-required="true">
                            <option value="" selected disabled>Scegli una categoria...</option>
                            <option value="Elettronica">Elettronica</option>
                            <option value="Vestiti">Vestiti</option>
                            <option value="Materiale scolastico">Materiale scolastico</option>
                            <option value="Altro">Altro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="luogo" class="form-label">Luogo</label>
                        <input type="text" id="luogo" name="luogo" class="form-control" 
                               placeholder="Es: Aula 3, Biblioteca..." required aria-required="true">
                    </div>

                    <div class="mb-3">
                        <label for="data" class="form-label">Data ritrovamento</label>
                        <input type="date" id="data" name="data" class="form-control" required aria-required="true">
                    </div>

                    <div class="mb-4">
                        <label for="foto" class="form-label">Carica una foto (opzionale)</label>
                        <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        Registra Oggetto
                    </button>
                </form>

            <?php elseif ($stato == "successo"): ?>
                <div class="text-center py-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                    <h2 class="h4 mt-3">Ottimo lavoro!</h2>
                    <p class="text-muted">L'oggetto è stato salvato correttamente.</p>
                    <div class="d-grid gap-2 mt-4">
                        <a href="upload.php" class="btn btn-primary">Inserisci un altro</a>
                        <a href="index.php" class="btn btn-outline-secondary">Torna alla Home</a>
                    </div>
                </div>

            <?php else: ?>
                <div class="text-center py-4">
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                    <h2 class="h4 mt-3">Attenzione</h2>
                    <div class="alert alert-danger mt-3">
                        <?php echo $messaggio_errore; ?>
                    </div>
                    <a href="upload.php" class="btn btn-danger w-100 mt-3">Riprova</a>
                </div>
            <?php endif; ?>

            <footer class="mt-4 text-center">
                <p class="small text-muted">
                    Hai dubbi? <a href="contatti.php" class="text-primary fw-bold">Contatta l'ufficio oggetti smarriti</a>
                </p>
            </footer>
        </div>
    </div>
</div>