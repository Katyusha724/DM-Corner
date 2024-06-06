<?php
session_start();
require 'database.php';

if (isset($_SESSION["user_id"])) {
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}
$user_id = $_SESSION["user_id"];

if (!isset($_GET['place_id'])) {
    die("Place ID is required.");
}

$_SESSION['place_id'] = $_GET['place_id'];
$place_id = $_SESSION['place_id'];

$mysqli = require __DIR__ . "/database.php"; 


// Check if there is already an entry in place_notes for this place_id
$sql = "SELECT * FROM place_notes WHERE place_id = ? AND user_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ii', $place_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$notes = $result->fetch_assoc();
$stmt->close();

// Fetch place details
$sql = "SELECT * FROM places WHERE id = ? AND user_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ii', $place_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$place = $result->fetch_assoc();
$stmt->close();

if (!$place) {
    die("Place not found or you do not have permission to view it.");
}



$mysqli->close();
?>


<?php include 'head-2.php'; ?>
<?php include 'place_redirect.php'; ?>
<body class="background-2">
<?php include 'navigation-2.php'; ?>

<div class="container">
    <?php include 'quick_nav.php'; ?>
    <nav class="quick-nav">
        <h1><a href="campaign_home.php?id=<?php echo $campaign_id; ?>"><?php echo htmlspecialchars($campaign_name); ?></a> /
        <a href="regions.php?campaign_id=<?php echo $campaign_id; ?>">Regions</a> / 
        <a href="places.php?region_id=<?php echo $region_id; ?>"><?php echo htmlspecialchars($region_name); ?></a> / 
        <b><?php echo htmlspecialchars($place['place_name']); ?></b>
    </h1>
    </nav>
</div>

<div class="grid-container-2">

<!---------------------------------------------PLACE INFO/NOTES------------------------------------------->

    <div class="place-info">
        <?php include 'place_notes.php'; ?>
    </div>

<!------------------------------------------BUILDINGS---------------------------------------->
    
    <div class="place-buildings">

        <div class="card-head">
            <h1>Buildings/Rooms</h1> 
            <button onclick="openAddBuildingForm()">Add new</button> 
        </div>

        <div class="card-body-1">
            <?php include 'building_list.php'; ?>
        </div>
    </div>

<!-----------------------------------------BUILDING INFO--------------------------------------->
        <div class="building-info">

            <div class="card-head">
                <h1>Building info</h1>
                <button>Edit</button>
            </div>

            <div class="card-body-1">

                <div class="building-info">

                <?php include 'building_description.php'; ?>

                    <div class="triple-diamond-deco-container">
                        <div class="left-line"></div>
                        <div class="right-line"></div>
                        <div class="small-diamond-left"></div>
                        <div class="small-diamond-right"></div>
                        <div class="large-diamond"></div>
                    </div>

                    <h2>NPCs</h2>
                    
                    <?php include 'npc.php'; ?>
                    

                    <div class="triple-diamond-deco-container">
                        <div class="left-line"></div>
                        <div class="right-line"></div>
                        <div class="small-diamond-left"></div>
                        <div class="small-diamond-right"></div>
                        <div class="large-diamond"></div>
                    </div>

                    <h2>Loot</h2>
                    <div class="loot-list">
                       
                        <?php include 'loot_item.php'; ?>
                            
                    </div>
                    
                    <div class="triple-diamond-deco-container">
                        <div class="left-line"></div>
                        <div class="right-line"></div>
                        <div class="small-diamond-left"></div>
                        <div class="small-diamond-right"></div>
                        <div class="large-diamond"></div>
                    </div>


                    <h2>Quests</h2>
                    <div class="quest">
                        <?php include 'quest.php'; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include 'footer.php'; ?>
</body>
</html>


