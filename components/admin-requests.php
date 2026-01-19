<?php
    $requests = $db_obj->getRequests();
?>

<div class="home-wrapper">
    <?php if (count($requests) == 0): ?>
        <div class="alert alert-info">
            There are no open requests
        </div>
    <?php else: ?>
        <?php 
            foreach( $requests as $request ):
                $object = $db_obj->getObject($request["oggetto_id"]);
        ?>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="uploads/<?php echo $object["foto"] ?>" class="img-fluid rounded-start" alt="">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $object["nome"] ?></h5>
                            <p class="card-text"><?php echo $object["categoria"] ?></p>
                            <p class="card-text"><small class="text-body-secondary"><?php echo $object["data_ritrovamento"] ?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>