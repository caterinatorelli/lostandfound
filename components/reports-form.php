<?php
require_once(__DIR__ . "/../utils/functions.php");
?>
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <h1 class="text-center mb-4 page-title">Le Mie Segnalazioni</h1>
            
            <?php if(isset($_GET['deleted'])): ?>
                <div class="alert alert-success text-center" role="alert">
                    <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
                    Segnalazione eliminata con successo.
                </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['success']) && $_GET['action'] == 'accept'): ?>
                <div class="alert alert-success text-center" role="alert">
                    <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
                    Richiesta accettata! L'oggetto è stato segnato come restituito.
                </div>
            <?php endif; ?>

            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                    Si è verificato un errore durante l'operazione.
                </div>
            <?php endif; ?>

            <p class="text-center text-muted mb-5">Visualizza gli oggetti che hai segnalato, gestisci le richieste o elimina i vecchi post.</p>

            <?php if(empty($reports)): ?>
                <div class="alert alert-info text-center" role="alert">
                    Non hai ancora fatto segnalazioni.
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach($reports as $report): ?>
                        <div class="col-12">
                            <article class="card <?php echo ($report['stato'] === 'restituito') ? 'border-success' : ''; ?>">
                                
                                <div class="card-header d-flex justify-content-between align-items-center <?php echo ($report['stato'] === 'restituito') ? 'bg-success text-white' : ''; ?>">
                                    <div>
                                        <h2 class="h5 card-title m-0"><?php echo htmlspecialchars($report['nome']); ?></h2>
                                        <p class="m-0 small <?php echo ($report['stato'] === 'restituito') ? 'text-white-50' : 'text-muted'; ?>">
                                            Segnalato il <time datetime="<?php echo htmlspecialchars($report['data_inserimento']); ?>"><?php echo htmlspecialchars($report['data_inserimento']); ?></time>
                                        </p>
                                    </div>
                                    
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="visually-hidden">Stato attuale: </span>
                                        <?php if($report['stato'] === 'restituito'): ?>
                                            <span class="badge bg-white text-success">RESTITUITO</span>
                                        <?php elseif($report['stato'] === 'pending'): ?>
                                            <span class="badge bg-warning text-dark">IN APPROVAZIONE</span>
                                        <?php elseif($report['stato'] === 'refused'): ?>
                                            <span class="badge bg-danger">RIFIUTATO</span>
                                        <?php else: ?>
                                            <span class="badge bg-primary">ATTIVO</span>
                                        <?php endif; ?>

                                        <form action="delete-object-api.php" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare la segnalazione per <?php echo addslashes($report['nome']); ?>? L\'azione è irreversibile.');" class="m-0">
                                            <input type="hidden" name="id" value="<?php echo $report['id']; ?>">
                                            <input type="hidden" name="source" value="my-reports">
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    aria-label="Elimina segnalazione: <?php echo htmlspecialchars($report['nome']); ?>">
                                                <i class="bi bi-trash" aria-hidden="true"></i> Elimina
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <ul class="list-unstyled">
                                                <li><strong>Categoria:</strong> <?php echo htmlspecialchars($report['categoria']); ?></li>
                                                <li><strong>Luogo:</strong> <?php echo htmlspecialchars($report['luogo']); ?></li>
                                                <li><strong>Data ritrovamento:</strong> <?php echo htmlspecialchars($report['data_ritrovamento']); ?></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <?php if(!empty($report['foto'])): ?>
                                                <img src="uploads/<?php echo htmlspecialchars($report['foto']); ?>" 
                                                     class="img-thumbnail" 
                                                     style="max-width: 150px;" 
                                                     alt="Foto anteprima di: <?php echo htmlspecialchars($report['nome']); ?>">
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <hr aria-hidden="true">

                                    <?php if($report['stato'] === 'restituito'): ?>
                                        <div class="alert alert-success m-0" role="alert">
                                            <i class="bi bi-check-circle-fill" aria-hidden="true"></i> 
                                            Questo oggetto è stato segnato come restituito.
                                        </div>
                                    <?php elseif($report['stato'] === 'refused'): ?>
                                        <div class="alert alert-danger m-0" role="alert">
                                            La segnalazione è stata rifiutata dagli amministratori.
                                        </div>
                                    <?php else: ?>
                                        <h3 class="h6">Richieste di ritiro:</h3>
                                        <?php
                                        $claims = $db_obj->getPendingClaimsForReport($report['id']);
                                        if(empty($claims)): ?>
                                            <p class="text-muted">Nessuna richiesta pendente.</p>
                                        <?php else: ?>
                                            <ul class="list-group">
                                                <?php foreach($claims as $claim): 
                                                    $richiedente = htmlspecialchars($claim['richiedente_nome'] ?? $claim['richiedente_email']);
                                                ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong><?php echo $richiedente; ?></strong> ha scritto:<br>
                                                            <span class="text-muted">"<?php echo htmlspecialchars($claim['messaggio']); ?>"</span>
                                                        </div>
                                                        <div class="d-flex gap-2">
                                                            <form action="manage-claim-api.php" method="POST" class="d-inline">
                                                                <input type="hidden" name="claim_id" value="<?php echo $claim['id']; ?>">
                                                                <input type="hidden" name="action" value="accept">
                                                                <button type="submit" class="btn btn-success btn-sm" 
                                                                        aria-label="Accetta richiesta di <?php echo $richiedente; ?> per <?php echo htmlspecialchars($report['nome']); ?>">
                                                                    Accetta
                                                                </button>
                                                            </form>
                                                            
                                                            <form action="manage-claim-api.php" method="POST" class="d-inline">
                                                                <input type="hidden" name="claim_id" value="<?php echo $claim['id']; ?>">
                                                                <input type="hidden" name="action" value="reject">
                                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                                        aria-label="Rifiuta richiesta di <?php echo $richiedente; ?>">
                                                                    Rifiuta
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>