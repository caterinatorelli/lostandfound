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
