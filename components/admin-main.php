<?php
    $openCases = $db_obj->getOpenCases();
    $openRequests = $db_obj->getRequests();
?>

<div class="home-wrapper">
    <div class="hero-box">
        <h1>Open requests</h1>
        <h2>There are currently <?php echo count($openRequests); ?> open requests</h2>

        <a href="manage-requests" class="btn btn-primary">Go requests</a>
    </div>

    <div class="hero-box">
        <h1>Open cases</h1>
        <h2>There are currently <?php echo count($openCases); ?> open cases</h2>

        <a href="search-objects.php" class="btn btn-primary">Go cases</a>
    </div>
</div>