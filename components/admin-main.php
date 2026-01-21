<?php
    $openCases = $db_obj->getOpenCases();
    $openRequests = $db_obj->getRequests();
?>

<div class="home-wrapper">
    <div class="hero-box">
        <h1>Richieste in sospeso</h1>
        <h2>ci sono attualmente  <?php echo count($openRequests); ?> richieste</h2>

        <a href="manage-requests.php" class="btn btn-primary">Vai alle richieste</a>
    </div>

    <div class="hero-box">
        <br>
        <h1>Report aperti</h1>
        <h2>Ci sono attualmente <?php echo count($openCases); ?> report</h2>
        <br>

        <a href="search-objects.php" class="btn btn-primary">Vai ai reports</a>
    </div>
</div>