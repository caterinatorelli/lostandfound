<?php
    $openCases = $db_obj->getOpenCases();
    $openRequests = $db_obj->getRequests();
?>

<div class="home-wrapper">
    <div class="hero-box">
        <h1>Open requests</h1>
        <h2>There are currently <?php echo count($openRequests); ?> open requests</h2>

        <a href="manage-requests.php" class="btn btn-primary">Go to open requests</a>
    </div>

    <div class="hero-box">
        <h1>Open reports</h1>
        <h2>There are currently <?php echo count($openCases); ?> open reports</h2>

        <a href="search-objects.php" class="btn btn-primary">Go to reports</a>
    </div>
</div>