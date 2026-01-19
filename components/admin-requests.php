<?php
    $requests = $db_obj->getRequests();
?>

<div class="home-wrapper">
    <?php if (count($requests) == 0): ?>
        <div class="alert alert-info">
            There are no open requests
        </div>
    <?php else: ?>
        <?php foreach( $requests as $request ): ?>
            <div class="card" style="width: 20rem;">
                <img src="uploads/<?php echo $request['foto'] ?>" class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $request['nome'] ?></h5>
                    <p class="card-text">
                        Submitted by: <?php echo $db_obj->getSubmitter( $request)['email'] ?>
                        <br>
                        Class: <?php echo $request['luogo'] ?>
                        <br>
                        Date: <?php echo $request['data_ritrovamento'] ?>
                        <br>
                        Categoria: <?php echo $request['categoria'] ?>
                    </p>
                    <div class="d-grid gap-2 d-md-block">
                        <a class="btn btn-outline-success" href="revision-api.php?o=<?php echo $request['id'] ?>&m=a">Approve</a>
                        <a class="btn btn-outline-danger" href="revision-api.php?o=<?php echo $request['id'] ?>&m=d">Deny</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
