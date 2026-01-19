<?php
require_once(__DIR__ . "/../utils/functions.php");

$reports = $templateParams["reports"] ?? [];
$message = $templateParams["message"] ?? '';
?>
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <h1 class="text-center mb-4 page-title">Le Mie Segnalazioni</h1>
            <p class="text-center text-muted mb-5">Visualizza gli oggetti che hai segnalato e gestisci le richieste di ritiro.</p>

            <?php if (!empty($message)): ?>
                <div class="alert alert-success text-center"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <?php if(empty($reports)): ?>
                <div class="alert alert-info text-center">Non hai ancora fatto segnalazioni.</div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach($reports as $report): ?>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><?php echo htmlspecialchars($report['nome']); ?></h5>
                                    <small class="text-muted">Segnalato il <?php echo htmlspecialchars($report['data_inserimento']); ?></small>
                                </div>
                                <div class="card-body">
                                    <p><strong>Categoria:</strong> <?php echo htmlspecialchars($report['categoria']); ?></p>
                                    <p><strong>Luogo:</strong> <?php echo htmlspecialchars($report['luogo']); ?></p>
                                    <p><strong>Data ritrovamento:</strong> <?php echo htmlspecialchars($report['data_ritrovamento']); ?></p>
                                    <?php if(!empty($report['foto'])): ?>
                                        <img src="uploads/<?php echo htmlspecialchars($report['foto']); ?>" class="img-thumbnail" style="max-width: 200px;">
                                    <?php endif; ?>

                                    <hr>
                                    <h6>Richieste di ritiro:</h6>
                                    <?php
                                    $claims = $db_obj->getPendingClaimsForReport($report['id']);
                                    if(empty($claims)): ?>
                                        <p class="text-muted">Nessuna richiesta pendente.</p>
                                    <?php else: ?>
                                        <ul class="list-group">
                                            <?php foreach($claims as $claim): ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong><?php echo htmlspecialchars($claim['richiedente_nome'] ?? $claim['richiedente_email']); ?></strong><br>
                                                        <small><?php echo htmlspecialchars($claim['messaggio']); ?></small><br>
                                                        <small class="text-muted">Richiesto il <?php echo htmlspecialchars($claim['creato']); ?></small>
                                                    </div>
                                                    <div>
                                                        <?php if ($claim['stato'] === 'accettata'): ?>
                                                            <span class="badge bg-success">Oggetto restituito!</span>
                                                        <?php elseif ($claim['stato'] === 'rifiutata'): ?>
                                                            <span class="badge bg-danger">Richiesta rifiutata</span>
                                                        <?php else: ?>
                                                            <form action="manage-claim-api.php" method="POST" class="d-inline">
                                                                <input type="hidden" name="claim_id" value="<?php echo $claim['id']; ?>">
                                                                <input type="hidden" name="action" value="accept">
                                                                <button type="submit" class="btn btn-success btn-sm">Accetta</button>
                                                            </form>
                                                            <form action="manage-claim-api.php" method="POST" class="d-inline ms-2">
                                                                <input type="hidden" name="claim_id" value="<?php echo $claim['id']; ?>">
                                                                <input type="hidden" name="action" value="reject">
                                                                <button type="submit" class="btn btn-danger btn-sm">Rifiuta</button>
                                                            </form>
                                                        <?php endif; ?>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>