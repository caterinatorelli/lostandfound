<div class="container-fluid search-objects-container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <h1 class="text-center mb-4 page-title">Cerca Oggetti Ritrovati</h1>
            <p class="text-center text-muted mb-5">Visualizza tutti gli oggetti segnalati e richiedi quelli che ti appartengono.</p>
            
            <div class="row g-4">
                <?php if(empty($items)): ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center">Nessuna segnalazione presente al momento.</div>
                    </div>
                <?php endif; ?>

                <?php foreach($items as $it): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card found-object-card">
                            <?php if(!empty($it['foto'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($it['foto']); ?>" class="card-img-top object-image" alt="<?php echo htmlspecialchars($it['nome']); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($it['nome']); ?></h5>
                                <?php if(!empty($it['categoria'])): ?>
                                    <p class="mb-1"><strong>Categoria:</strong> <?php echo htmlspecialchars($it['categoria']); ?></p>
                                <?php endif; ?>
                                <?php if(!empty($it['luogo'])): ?>
                                    <p class="mb-1"><strong>Luogo:</strong> <?php echo htmlspecialchars($it['luogo']); ?></p>
                                <?php endif; ?>
                                <?php if(!empty($it['data_ritrovamento'])): ?>
                                    <p class="mb-1"><strong>Data ritrovamento:</strong> <?php echo htmlspecialchars($it['data_ritrovamento']); ?></p>
                                <?php endif; ?>
                                <?php if(!empty($it['descrizione'])): ?>
                                    <p class="small text-muted"><?php echo nl2br(htmlspecialchars($it['descrizione'])); ?></p>
                                <?php endif; ?>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <?php if(isUserLoggedIn()): ?>
                                        <form action="/claim-api.php" method="POST" class="d-flex gap-2 w-100">
                                            <input type="hidden" name="object_id" value="<?php echo (int)$it['id']; ?>">
                                            <input type="hidden" name="message" value="Chiedo il ritiro dell'oggetto.">
                                            <button type="submit" class="btn btn-success w-100 claim-btn">È mio</button>
                                        </form>
                                    <?php else: ?>
                                        <a href="/login.php" class="btn btn-outline-primary w-100">Accedi per richiedere</a>
                                    <?php endif; ?>
                                </div>

                                <?php if(!empty($it['inseritore_nome']) || !empty($it['inseritore_email'])): ?>
                                    <small class="text-muted d-block mt-2">Segnalato da: <?php echo htmlspecialchars($it['inseritore_nome'] ?? $it['inseritore_email']); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>