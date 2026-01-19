<div class="container stats-wrapper">
    
    <h1 class="text-center page-title">Statistiche Ritrovamenti</h1>

    <div class="row g-4 justify-content-center">
        
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h2>Luoghi</h2>
                </div>
                <div class="card-body p-4">
                    <canvas id="canvasLuoghi" role="img" aria-label="Grafico a ciambella interattivo: distribuzione oggetti per luogo" tabindex="0"></canvas>
                    
                    <div class="sr-only">
                        <table summary="Tabella di dettaglio per screen reader sui luoghi">
                            <caption>Dati grafici: Luoghi</caption>
                            <thead>
                                <tr>
                                    <th scope="col">Luogo</th>
                                    <th scope="col">Oggetti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($datiLuoghi as $riga): ?>
                                <tr>
                                    <td><?= htmlspecialchars($riga['etichetta']) ?></td>
                                    <td><?= $riga['totale'] ?></td>
                                </tr>
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
                    <canvas id="canvasCategorie" role="img" aria-label="Grafico a ciambella interattivo: distribuzione oggetti per categoria" tabindex="0"></canvas>
                    
                    <div class="sr-only">
                        <table summary="Tabella di dettaglio per screen reader sulle categorie">
                            <caption>Dati grafici: Categorie</caption>
                            <thead>
                                <tr>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Oggetti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($datiCategorie as $riga): ?>
                                <tr>
                                    <td><?= htmlspecialchars($riga['etichetta']) ?></td>
                                    <td><?= $riga['totale'] ?></td>
                                </tr>
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

    document.addEventListener("DOMContentLoaded", function() {
        creaGrafico('canvasLuoghi', datiLuoghiJS, 'Distribuzione per Luogo');
        creaGrafico('canvasCategorie', datiCategorieJS, 'Distribuzione per Categoria');
    });
</script>