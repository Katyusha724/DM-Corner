<?php
session_start();
require 'database.php';

if (isset($_SESSION["user_id"])) {
    $sql = "SELECT * FROM user WHERE id = {$_SESSION['user_id']}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}

include 'session_redirect.php';

$user_id = $_SESSION['user_id'];

// Fetch the campaign ID
if (!isset($_GET['campaign_id'])) {
    die("Campaign ID is required.");
}

$_SESSION['campaign_id'] = $_GET['campaign_id'];
$campaign_id = $_SESSION['campaign_id'];

$mysqli = require __DIR__ . "/database.php";

// Fetch all sessions for the campaign
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

<div class="container">
    <?php include 'quick_nav.php'; ?>
    <nav class="quick-nav">
        <h1><a href="campaign_home.php?id=<?php echo $campaign_id; ?>"><?php echo htmlspecialchars($campaign_name); ?></a> /
        Session Planner
    </h1>
    </nav>
</div>

<div class="grid-container">
    <div class="session-list">
        <div class="card-head">
             <h2>Sessions</h2>
             <button onclick="openAddSessionForm()">Add Session</button> 
        </div>
       
        <div class="card-body-1">
            <ul>
                <?php foreach ($sessions as $session): ?>
                    <li>
                        <a href="sessions.php?campaign_id=<?php echo $campaign_id; ?>&session_id=<?php echo $session['id']; ?>"><?php echo htmlspecialchars($session['session_name']); ?></a>
                        <button onclick="confirmDelete(<?php echo $session['id']; ?>)">Delete</button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="session-notes">

        <div id="addSessionForm" style="display: none; color: #fff;" class="blur-box">
            <form method="post" action="session_add.php">
                <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>">
                <label for="session_name"><h2>Session Name:</h2></label>
                <input type="text" name="session_name" required>
                <button type="submit" name="add_session">Add Session</button>
            </form>
        </div>

        <?php
        if (isset($_GET['session_id'])) {
            $session_id = $_GET['session_id'];
            $mysqli = require __DIR__ . "/database.php";
            $sql = "SELECT * FROM sessions WHERE id = ? AND campaign_id = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('ii', $session_id, $campaign_id);
            $stmt->execute();
            $session_result = $stmt->get_result();
            $session = $session_result->fetch_assoc();
            $stmt->close();
            $mysqli->close();
            
            if ($session) {
                // Display session details
                ?>
                <div class="card-head">
                    <h2><?php echo htmlspecialchars($session['session_name']); ?></h2>
                </div>
                <div class="card-body-1">

                    <form method="post" action="session_update.php">
                        <input type="hidden" name="session_id" value="<?php echo $session_id; ?>">
                        <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>">
                        <label for="session_name">Session Name:</label>
                        <input type="text" name="session_name" value="<?php echo htmlspecialchars($session['session_name']); ?>" required>
                        <label for="notes">Notes:</label>
                        <textarea name="notes"><?php echo htmlspecialchars($session['notes']); ?></textarea>
                        <label for="bullet_points">Bullet Points (separate with commas):</label>
                        <textarea name="bullet_points"><?php echo htmlspecialchars($session['bullet_points']); ?></textarea>
                        <button type="submit" name="save_changes">Save Changes</button>
                    </form>
                </div>
                <?php
            } else {
                echo "<p>Session not found.</p>";
            }
        }
        ?>
    </div>
</div>

<script>
    function openAddSessionForm() {
        document.getElementById('addSessionForm').style.display = 'block';
    }

    function confirmDelete(sessionId) {
        var result = confirm("Are you sure you want to delete this session?");
        if (result) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'session_redirect.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'session_id';
            input.value = sessionId;

            var campaignInput = document.createElement('input');
            campaignInput.type = 'hidden';
            campaignInput.name = 'campaign_id';
            campaignInput.value = <?php echo $campaign_id; ?>;

            var deleteInput = document.createElement('input');
            deleteInput.type = 'hidden';
            deleteInput.name = 'delete_session';
            deleteInput.value = true;

            form.appendChild(input);
            form.appendChild(campaignInput);
            form.appendChild(deleteInput);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

<?php include 'footer.php'; ?>
</body>
</html>
