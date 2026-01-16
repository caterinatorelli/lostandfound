<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5">
            <div class="card shadow p-4">
                <h1 class="text-center h3 mb-4">Log in to Lost and Found</h1>
                
                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger">User does not exist or passowrd is wrong</div>
                <?php endif; ?>

                <form action="login-api.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Email:</label>
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
                    <p>Non hai un account? <a href="register.php" class="text-primary fw-bold">Registrati</a></p>
                </div>
            </div>
        </div>
    </div>
</div>