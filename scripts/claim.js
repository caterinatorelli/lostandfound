document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.claim-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const section = this.closest('.claim-section');
            
            fetch('/lostandfound/claim-api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    section.innerHTML = '<div class="alert alert-success text-center">Richiesta inviata!</div>';
                } else {
                    alert('Errore: ' + (data.error || 'Errore sconosciuto'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Errore di connessione.');
            });
        });
    });
});