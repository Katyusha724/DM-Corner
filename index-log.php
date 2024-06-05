<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DM Corner</title>
    <link rel="stylesheet" href="Style/style.css">
</head>

<body class="background-2">
    <canvas id="canvas"></canvas>
    <?php include 'navigation-2.php'; ?>
    
    <div class="index-log">
        <div class="container">
        
        <div class="campaigns">
            <h1>Campaigns</h1>
            <div class="triple-diamond-deco-container">
                <div class="left-line"></div>
                <div class="right-line"></div>
                <div class="small-diamond-left"></div>
                <div class="small-diamond-right"></div>
                <div class="large-diamond"></div>
            </div>
            <div class="campaign_list">
                <?php include 'campaign_listing.php'; ?>
            </div>
        </div>
    

    
        <div class="create-campaign">
            <h1>Create Campaign</h1>
            <div class="triple-diamond-deco-container">
                <div class="left-line"></div>
                <div class="right-line"></div>
                <div class="small-diamond-left"></div>
                <div class="small-diamond-right"></div>
                <div class="large-diamond"></div>
            </div>
            <?php include 'campaign_create.php'; ?>
        </div>
        
    </div>
    </div>
    
    

    <?php include 'footer.php'; ?>
    
</body>
</html>