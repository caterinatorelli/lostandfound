<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

<style>
    /* Contenitore principale flessibile */
    .home-wrapper {
        display: flex;
        justify-content: center; /* Centra i due blocchi nella pagina */
        align-items: center;     /* Centra verticalmente */
        min-height: 80vh;        
        padding: 20px;
        gap: 30px; /* Spazio tra i due riquadri */
        flex-wrap: wrap; /* Se lo schermo è piccolo, manda a capo il secondo box */
        box-sizing: border-box;
    }

    /* Stile comune per i riquadri */
    .hero-box {
        background: white;
        padding: 30px 40px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        text-align: center;
        max-width: 500px; /* Ridotto leggermente per farne stare due affiancati */
        width: 100%;
        flex: 1 1 300px; /* Permette ai box di adattarsi ma non diventare minuscoli */
    }

    /* Stile Titolo */
    .hero-box h1 {
        font-family: 'Montserrat', sans-serif;
        font-size: 2.5rem;
        color: #27ae60; 
        margin: 0 0 5px 0;
        text-transform: uppercase;
        letter-spacing: -1px;
        line-height: 1.1;
    }

    /* Stile Sottotitolo */
    .hero-box h2 {
        font-family: 'Montserrat', sans-serif;
        font-size: 1rem;
        color: #7f8c8d;
        margin: 10px 0 15px 0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    /* Linea decorativa */
    .divider {
        height: 3px;
        width: 40px;
        background-color: #27ae60;
        margin: 0 auto 15px auto;
        border-radius: 2px;
    }

    /* Paragrafo */
    .hero-box p {
        font-family: 'Open Sans', sans-serif;
        font-size: 0.9rem;
        line-height: 1.5;
        color: #555;
        margin: 0 auto;
    }
</style>

<div class="home-wrapper">
    
    <div class="hero-box">
        <h1>Lost and Found</h1>
        <h2>Chi siamo</h2>
        <div class="divider"></div>
        <p>
            Benvenuti su <strong>Lost and Found</strong>. La piattaforma digitale che semplifica il ritrovamento dei tuoi oggetti smarriti. 
            Connettiamo chi ha perso qualcosa con chi l'ha ritrovato tramite un sistema rapido e sicuro, rendendo la restituzione semplice grazie alla nostra community.
        </p>
    </div>

    <div class="hero-box">
        <h1>Policy</h1> <h2>La nostra politica</h2>
        <div class="divider"></div>
        <p>
            Crediamo nella fiducia e nella trasparenza. La nostra politica si basa sulla tutela della privacy degli utenti e sulla verifica delle segnalazioni. 
            Non richiediamo commissioni sugli oggetti ritrovati e monitoriamo costantemente la piattaforma per garantire un ambiente sicuro e collaborativo per tutti.
        </p>
    </div>

</div>