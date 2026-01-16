<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card shadow p-4">
            <h1 class="text-center h3 mb-4">Crea un account</h1>
            
            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger">An error occured, try later</div>
            <?php endif; ?>

            <form action="register-api.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Universitaria</label>
                    <input type="email" 
                            id="email" 
                            name="email" 
                            class="form-control" 
                            required 
                            aria-required="true"
                            placeholder="esempio@studenti.it"
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
                    Hai già un account? <a href="login.php" class="text-primary fw-bold" aria-label="Vai alla pagina di login">Accedi qui</a>
                </p>
            </footer>
        </div>
    </div>
