<?php
session_start();
require 'database.php';

if (isset($_SESSION["user_id"])) {
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}


$mysqli = require __DIR__ . "/database.php";

// Check if the user is logged in by verifying the session variable
if (!isset($_SESSION['user_id'])) {
    die('You are not logged in.');
}

$user_id = $_SESSION['user_id'];
$campaign_id = $_SESSION['campaign_id'];


// Fetch regions
$sql = "SELECT * FROM regions WHERE user_id = ? AND campaign_id = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die('Prepare failed: ' . $mysqli->error);
}

$stmt->bind_param('ii', $user_id, $campaign_id);
$stmt->execute();
$result = $stmt->get_result();
$regions = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$mysqli->close();

?>

<?php include 'head-2.php'; ?>
<body class="background-2">
<canvas id="canvas"></canvas>
    <?php include 'navigation-2.php'; ?>
    <div class="container">
        
    <?php include 'quick_nav.php'; ?>
        <nav class="quick-nav">
        <h1><a href="campaign_home.php?id=<?php echo $campaign_id; ?>"><?php echo htmlspecialchars($campaign_name); ?></a> /
            <a href="regions.php?campaign_id=<?php echo $campaign_id; ?>">Regions</a> </h1>
        </nav>

    </div>

    <div class="grid-container">

        <div class="region-list">
            <div class="card-head">
                <h1>Regions</h1>
            </div>

            <div class="card-body-1">
                <?php if (empty($regions)): ?>

                    <p>There are no created regions.</p> <br>

                    <?php else: ?>
                        <div class="region-listing-1">
                            <?php include 'region_view.php'; ?>
                        </div>
                        
                <?php endif; ?>

            </div>
        </div>

        <div class="region-info">
            <?php include 'region_create.php'; ?>
        </div>

    </div>

    <?php include 'footer.php'; ?>
    
</body>
</html>