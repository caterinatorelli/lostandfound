<?php
    $requests = $db_obj->getRequests();
?>

<?php if (isset($errore)): ?>
    <div class="alert alert-danger my-4">
        Errore nella richiesta
    </div>
<?php endif; ?>

<div class="home-wrapper">
    <?php if (count($requests) == 0): ?>
        <div class="alert alert-info">
            Non ci sono richieste aperte
        </div>
    <?php else: ?>
        <?php foreach( $requests as $request ): ?>
            <div class="card" style="width: 20rem;">
                <img src="uploads/<?php echo $request['foto'] ?>" class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $request['nome'] ?></h5>
                    <p class="card-text">
                        Fatta da: <?php echo $db_obj->getSubmitter( $request)['email'] ?>
                        <br>
                        Luogo: <?php echo $request['luogo'] ?>
                        <br>
                        Data ritrovamento: <?php echo $request['data_ritrovamento'] ?>
                        <br>
                        Categoria: <?php echo $request['categoria'] ?>
                    </p>
                    <div class="d-grid gap-2 d-md-block">
                        <!--
                            <a class="btn btn-outline-success" href="revision-api.php?o=<?php echo $request['id'] ?>&m=a">Accetta</a>
                            <a class="btn btn-outline-danger" href="revision-api.php?o=<?php echo $request['id'] ?>&m=d">Rifiuta</a>
                        -->

                        <button class="btn btn-outline-success" onclick="requestAction(true, <?php echo $request['id'] ?>)">Accetta</a>
                        <button class="btn btn-outline-danger" onclick="requestAction(false, <?php echo $request['id'] ?>)">Rifiuta</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script src="scripts/requests.js"></script>
