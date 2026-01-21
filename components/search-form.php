<div class="container-fluid search-objects-container py-5">
    <?php $items = $templateParams["items"] ?? []; ?>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <h1 class="text-center mb-4 page-title">Cerca Oggetti Ritrovati</h1>
            <p class="text-center text-muted mb-5">Visualizza tutti gli oggetti segnalati e richiedi quelli che ti appartengono.</p>
            
            <?php if(isset($_GET['deleted'])): ?>
                <div class="alert alert-success text-center" role="alert">
                    <span class="bi bi-check-circle-fill" aria-hidden="true"></span>
                    Oggetto eliminato con successo.
                </div>
            <?php endif; ?>
            
            <div class="row g-4">
                <?php if(empty($items)): ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center" role="alert">
                            Nessuna segnalazione presente al momento.
                        </div>
                    </div>
                <?php endif; ?>

                <?php foreach($items as $it): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <article class="card found-object-card h-100">
                            <?php if(!empty($it['foto'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($it['foto']); ?>" 
                                     class="card-img-top object-image" 
                                     alt="Foto dell'oggetto: <?php echo htmlspecialchars($it['nome']); ?>">
                            <?php else: ?>
                                <div class="card-img-top object-image d-flex align-items-center justify-content-center bg-light">
                                    <span class="text-muted">Nessuna immagine</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body d-flex flex-column">
                                <h2 class="h5 card-title"><?php echo htmlspecialchars($it['nome']); ?></h2>
                                
                                <div class="flex-grow-1">
                                    <?php if(!empty($it['categoria'])): ?>
                                        <p class="mb-1">
                                            <span class="visually-hidden">Categoria:</span>
                                            <strong><span class="bi bi-tag" aria-hidden="true"></span></strong> 
                                            <?php echo htmlspecialchars($it['categoria']); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($it['luogo'])): ?>
                                        <p class="mb-1">
                                            <span class="visually-hidden">Luogo di ritrovamento:</span>
                                            <strong><span class="bi bi-geo-alt" aria-hidden="true"></span></strong> 
                                            <?php echo htmlspecialchars($it['luogo']); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($it['data_ritrovamento'])): ?>
                                        <p class="mb-1">
                                            <span class="visually-hidden">Data di ritrovamento:</span>
                                            <strong><span class="bi bi-calendar" aria-hidden="true"></span></strong> 
                                            <?php echo htmlspecialchars($it['data_ritrovamento']); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($it['descrizione'])): ?>
                                        <p class="small text-muted mt-2">
                                            <span class="visually-hidden">Descrizione:</span>
                                            <?php echo nl2br(htmlspecialchars($it['descrizione'])); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <?php 
                                    $currentUserId = $_SESSION['user_id'] ?? -1;
                                    $isOwner = ($it['id_inseritore'] == $currentUserId);
                                    $isAdmin = (isset($_SESSION['ruolo']) && $_SESSION['ruolo'] === 'admin');
                                ?>

                                <div class="mt-3 claim-section" data-object-id="<?php echo (int)$it['id']; ?>">
                                    <?php if(!$isOwner): ?>
                                        <?php if(isUserLoggedIn()): ?>
                                            <form action="claim-api.php" method="POST" class="claim-form w-100">
                                                <input type="hidden" name="object_id" value="<?php echo (int)$it['id']; ?>">
                                                <input type="hidden" name="message" value="Chiedo il ritiro dell'oggetto.">
                                                <button type="submit" class="btn btn-success w-100 claim-btn" 
                                                        aria-label="Rivendica l'oggetto: <?php echo htmlspecialchars($it['nome']); ?>">
                                                    È mio
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <a href="login.php" class="btn btn-outline-primary w-100" 
                                               aria-label="Accedi per rivendicare <?php echo htmlspecialchars($it['nome']); ?>">
                                                Accedi per richiedere
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <?php if ($isAdmin || $isOwner): ?>
                                    <hr aria-hidden="true">
                                    <div class="d-flex justify-content-end">
                                        <form action="delete-object-api.php" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare l\'oggetto <?php echo addslashes($it['nome']); ?>?');">
                                            <input type="hidden" name="id" value="<?php echo $it['id']; ?>">
                                            <input type="hidden" name="source" value="search">
                                            
                                            <?php if($isAdmin): ?>
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                        aria-label="Admin: Elimina l'oggetto <?php echo htmlspecialchars($it['nome']); ?> dal sistema">
                                                    <span class="bi bi-trash" aria-hidden="true"></span> Elimina Segnalazione
                                                </button>
                                            <?php else: ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                        aria-label="Elimina la tua segnalazione per <?php echo htmlspecialchars($it['nome']); ?>">
                                                    <span class="bi bi-trash" aria-hidden="true"></span> Elimina il mio oggetto
                                                </button>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                <?php endif; ?>

                                <?php if(!empty($it['inseritore_email'])): ?>
                                    <small class="text-muted d-block mt-2 text-end">
                                        Segnalato da: <?php echo htmlspecialchars($it['inseritore_email']); ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="scripts/claim.js"></script>