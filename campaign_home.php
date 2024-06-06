<?php
session_start();
require __DIR__ . '/database.php';


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

// Get the campaign ID from the URL parameter
if (!isset($_GET['id'])) {
    die('Campaign ID not specified.');
}


$_SESSION['campaign_id'] = $_GET['id'];
$campaign_id = $_SESSION['campaign_id'];

// Fetch the campaign details
$sql = "SELECT * FROM campaigns WHERE id = ? AND user_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ii', $campaign_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Campaign not found.');
}

$campaign = $result->fetch_assoc();

$stmt->close();

// Fetch regions within the campaign
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


// Fetch the players within the campaign
$sql = "SELECT * FROM players WHERE user_id = ? AND campaign_id = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die('Prepare failed: ' . $mysqli->error);
}

$stmt->bind_param('ii', $user_id, $campaign_id);
$stmt->execute();
$result = $stmt->get_result();
$players = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close(); 

// Fetch the sessions within the campaign
$sql = "SELECT id, session_name FROM sessions WHERE campaign_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $campaign_id);
$stmt->execute();
$sessions_result = $stmt->get_result();
$sessions = $sessions_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();


$mysqli->close();
?>


<?php include 'head-2.php'; ?>
<body class="background-2">

    <?php include 'navigation-2.php'; ?>
    
<br>
    <div class="grid-container">

<!---------------------CAMPAIGN INFO-------------------->
        <div class="Campaign-info">

            <div class="card-head">
                <h1><?php echo htmlspecialchars($campaign['name']); ?></h1>
            </div>

            <div class="card-body-1">
                <p><?php echo htmlspecialchars($campaign['description']); ?></p>
                <a class="story-link" href="story_view.php?campaign_id=<?php echo $campaign_id; ?>">View Story</a>
            </div>

            
        </div>

<!---------------------PARTY-------------------->
        <div class="Party">

            <div class="card-head">
                <h1>Players</h1>
                <a href="players.php?campaign_id=<?php echo $campaign_id; ?>">View all</a>
            </div>

            <div class="card-body-1 row">
                <?php if (empty($players)): ?>
                    <p>There are no players in the party.</p>
                    <?php else: ?>
                        
                        <?php
                        $mysqli = require __DIR__ . "/database.php";
                        $sql = "SELECT * FROM players WHERE campaign_id = ? AND user_id = ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param('ii', $campaign_id, $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $player = $result->fetch_all(MYSQLI_ASSOC);
                        $stmt->close();
                        $mysqli->close();
                        ?>
                        <?php foreach ($players as $player): ?>
                            <div class="player-card-1">
                               <h3><?php echo htmlspecialchars($player['character_name']); ?></h3>
                               <hr>
                               <p><b><?php echo htmlspecialchars($player['player_class']); ?></b> <br>
                               <?php echo htmlspecialchars($player['player_race']); ?></p>
                            </div>
                        <?php endforeach; ?>
                        
                <?php endif; ?>
            </div>

        </div>

<!---------------------SESSIONS-------------------->
        <div class="Sessions">

            <div class="card-head">
                <h1>Session Planer</h1>
                <a href="sessions.php?campaign_id=<?php echo $campaign_id; ?>">View all</a>
            </div>

            <div class="card-body-1">
                <ul>
                    <?php foreach ($sessions as $session): ?>
                        <li>
                            <a href="sessions.php?campaign_id=<?php echo $campaign_id; ?>&session_id=<?php echo $session['id']; ?>"><?php echo htmlspecialchars($session['session_name']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>


<!---------------------PLACES-------------------->
        <div class="Places">

            <div class="card-head">
                <h1>Places</h1>
                <a href="regions.php?campaign_id=<?php echo $campaign_id; ?>">View all</a>
            </div>

            <div class="card-body-1">

            <?php if (empty($regions)): ?>
                <p>There are no created regions.</p>
                <?php else: ?>
                    <div class="dropdown">
                        <ul>
                            <?php foreach ($regions as $region): ?>
                                <li>
                                    <button onclick="open_menu(this)" class="dropbtn"><?php echo htmlspecialchars($region['region_name']); ?></button>
                                    <div class="dropdown-content myDropdown">
                                        <ul>
                                            <?php
                                            $mysqli = require __DIR__ . "/database.php";
                                            $sql = "SELECT * FROM places WHERE region_id = ?";
                                            $stmt = $mysqli->prepare($sql);
                                            $stmt->bind_param('i', $region['id']);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $places = $result->fetch_all(MYSQLI_ASSOC);
                                            $stmt->close();
                                            $mysqli->close();
                                            ?>
                                            <?php foreach ($places as $place): ?>
                                                <li><a href="place_dashboard.php?place_id=<?php echo $place['id']; ?>"><?php echo htmlspecialchars($place['place_name']); ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

            <?php endif; ?>

            </div>

        </div>
        </div>

<!---------------------JAVASCRIPT-------------------->
    <script type="text/javascript">
        function open_menu(button) {
        var dropdownContent = button.nextElementSibling;
        dropdownContent.classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
    </script>

<?php include 'footer.php'; ?>

    
</body>
</html>


