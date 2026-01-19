<div class="container stats-wrapper">
    
    <h1 class="text-center page-title">Statistiche Ritrovamenti</h1>

    <div class="row g-4 justify-content-center">
        
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h2>Luoghi</h2>
                </div>
                <div class="card-body p-4">
                    <canvas id="canvasLuoghi" role="img" aria-label="Grafico a ciambella che mostra la distribuzione degli oggetti per luogo"></canvas>
                        <div class="visually-hidden">
                            <table>
                                </table>
                        </div>
                    
                    <div class="sr-only">
                        <table>
                            <thead><tr><th>Luogo</th><th>Oggetti</th></tr></thead>
                            <tbody>
                                <?php foreach($datiLuoghi as $riga): ?>
                                <tr><td><?= htmlspecialchars($riga['etichetta']) ?></td><td><?= $riga['totale'] ?></td></tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h2>Categorie</h2>
                </div>
                <div class="card-body p-4">
                    <canvas id="canvasCategorie" role="img" aria-label="Grafico a ciambella che mostra la distribuzione degli oggetti per categoria"></canvas>
                        <div class="visually-hidden">
                            </div>
                    <div class="sr-only">
                        <table>
                            <thead><tr><th>Categoria</th><th>Oggetti</th></tr></thead>
                            <tbody>
                                <?php foreach($datiCategorie as $riga): ?>
                                <tr><td><?= htmlspecialchars($riga['etichetta']) ?></td><td><?= $riga['totale'] ?></td></tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="scripts/statistic.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Recupera i dati PHP
    const datiLuoghiJS = <?php echo json_encode($datiLuoghi); ?> || [];
    const datiCategorieJS = <?php echo json_encode($datiCategorie); ?> || [];

    // Ora 'Chart' esiste, quindi 'creaGrafico' funzionerà
    document.addEventListener("DOMContentLoaded", function() {
        creaGrafico('canvasLuoghi', datiLuoghiJS, 'Distribuzione per Luogo');
        creaGrafico('canvasCategorie', datiCategorieJS, 'Distribuzione per Categoria');
    });
</script>