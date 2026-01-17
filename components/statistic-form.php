<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiche Campus</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



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

<script>
    // Configurazione Colori
    const coloriCampus = [
        '#198754', // Verde Campus (Principale)
        '#20c997', // Verde Acqua
        '#ffc107', // Giallo (Accento)
        '#0dcaf0', // Azzurro (Accento)
        '#6c757d', // Grigio
        '#146c43', // Verde Scuro
        '#d63384'  // Rosa (per contrasto se serve)
    ];

    function creaGrafico(idElemento, datiPHP, titoloGrafico) {
        if (!datiPHP || datiPHP.length === 0) return;

        const etichette = datiPHP.map(d => d.etichetta);
        const valori = datiPHP.map(d => d.totale);

        const ctx = document.getElementById(idElemento).getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: etichette,
                datasets: [{
                    label: 'Numero Oggetti',
                    data: valori,
                    backgroundColor: coloriCampus,
                    borderColor: '#ffffff',
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { 
                        position: 'bottom',
                        labels: {
                            font: { size: 12, family: "'Segoe UI', sans-serif" },
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: '#198754', // Tooltip Verde
                        titleFont: { size: 14 },
                        bodyFont: { size: 14 },
                        padding: 10,
                        cornerRadius: 10
                    }
                },
                layout: {
                    padding: 10
                }
            }
        });
    }

    const datiLuoghiJS = <?php echo json_encode($datiLuoghi); ?> || [];
    const datiCategorieJS = <?php echo json_encode($datiCategorie); ?> || [];

    creaGrafico('canvasLuoghi', datiLuoghiJS, 'Distribuzione per Luogo');
    creaGrafico('canvasCategorie', datiCategorieJS, 'Distribuzione per Categoria');
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>