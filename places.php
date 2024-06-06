<?php
session_start();
require 'database.php'; // Ensure this path is correct

if (isset($_SESSION["user_id"])) {
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

if (!isset($_GET['region_id'])) {
    die("Region ID is required.");
}

$user_id = $_SESSION['user_id'];

$_SESSION['region_id'] = $_GET['region_id'];
$region_id = $_SESSION['region_id'];

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM places WHERE region_id = ? AND user_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ii', $region_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include 'head-2.php'; ?>
<body class="background-2">
    
    <?php include 'navigation-2.php'; ?>
    <div class="container">
        
    <?php include 'quick_nav.php'; ?>
        <nav class="quick-nav">
            <h1><a href="campaign_home.php?id=<?php echo $campaign_id; ?>"><?php echo htmlspecialchars($campaign_name); ?></a> /
            <a href="regions.php?campaign_id=<?php echo $campaign_id; ?>">Regions</a> / 
            <a href="places.php?region_id=<?php echo $region_id; ?>"><?php echo htmlspecialchars($region_name); ?></a></h1>
        </nav>

    </div>

    <div class="grid-container">

        <div class="towns-list">
            <div class="card-head">
                <h1><?php echo htmlspecialchars($region_name); ?></h1>
            </div>

            <div class="card-body-1">
                <?php if (empty($result)): ?>

                    <p>There are no created places.</p> <br>

                    <?php else: ?>
                        <div class="region-listing-1">
                            <?php include 'places_list.php'; ?>
                        </div>
                    
                <?php endif; ?>

            </div>
        </div>

        <div class="create-town">
            
                <h1>Create Town/Place</h1>
            

            <?php include 'place_create.php'; ?>
            
        </div>

    </div>

    <?php include 'footer.php'; ?>
    
</body>
</html>
