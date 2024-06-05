<?php
session_start();
require 'database.php';

if (isset($_SESSION["user_id"])) {
    $sql = "SELECT * FROM user WHERE id = {$_SESSION['user_id']}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}

if (!isset($_GET['campaign_id'])) {
    die("Campaign ID is required.");
}

$_SESSION['campaign_id'] = $_GET['campaign_id'];
$campaign_id = $_SESSION['campaign_id'];
$mysqli = require __DIR__ . "/database.php";

// Fetch all story sections for the campaign
$sql = "SELECT id, section_title, content FROM story WHERE campaign_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $campaign_id);
$stmt->execute();
$story_result = $stmt->get_result();
$stories = $story_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$mysqli->close();
?>

<?php include 'head-2.php'; ?>
<body class="background-2">
<?php include 'navigation-2.php'; ?>
<div class="container">
    <nav class="quick-nav">
        <h1><a href="campaign_home.php?id=<?php echo $campaign_id; ?>">Campaign Dashboard</a> /
        Story Planer</h1>
    </nav>
</div>

<div class="grid-container">
    <div class="session-list">
        <div class="card-head">
            <h1>Story Sections</h1>
            <div>
                <button onclick="openAddStoryForm()">Add Story Section</button>
            </div>
        </div>
        <div class="card-body-1">
            <div id="addStoryForm" style="display: none;">
                <form method="post" action="story_add.php">
                    <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>">
                    <label for="section_title">Section Title:</label>
                    <input type="text" name="section_title" required>
                    <label for="content">Content:</label>
                    <textarea name="content" required></textarea>
                    <button type="submit" name="add_story">Add Story</button>
                </form>
            </div>
        
            <?php foreach ($stories as $story): ?>
            <div class="story-section">
                <h2><?php echo htmlspecialchars($story['section_title']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($story['content'])); ?></p>
                <button onclick="openEditForm(<?php echo $story['id']; ?>)">Edit</button>
                <button onclick="openDeleteConfirm(<?php echo $story['id']; ?>)">Delete</button>
                
                <div id="deleteConfirm-<?php echo $story['id']; ?>" class="delete-confirm" style="display: none;">
                    <div class="popup-content">
                        <p>Are you sure you want to delete this story section?</p>
                        <div class="popup-buttons">
                            <form method="post" action="story_delete.php">
                                <input type="hidden" name="story_id" value="<?php echo $story['id']; ?>">
                                <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>">
                                <button type="submit" name="delete_story" class="delete-button">Yes, Delete</button>
                            </form>
                            <button type="button" onclick="closeDeleteConfirm(<?php echo $story['id']; ?>)" class="cancel-button">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="session-notes">
        <div class="card-head"></div>
        <div class="card-body-1">
            <?php foreach ($stories as $story): ?>
            <div id="editForm-<?php echo $story['id']; ?>" style="display: none;">
                <form method="post" action="story_update.php">
                    <input type="hidden" name="story_id" value="<?php echo $story['id']; ?>">
                    <input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>">
                    <label for="section_title">Section Title:</label>
                    <input type="text" name="section_title" value="<?php echo htmlspecialchars($story['section_title']); ?>" required>
                    <label for="content">Content:</label>
                    <textarea name="content" required><?php echo htmlspecialchars($story['content']); ?></textarea>
                    <button type="submit" name="update_story">Update Story</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
function openAddStoryForm() {
    document.getElementById('addStoryForm').style.display = 'block';
}

function openEditForm(storyId) {
    document.getElementById('editForm-' + storyId).style.display = 'block';
}

function openDeleteConfirm(storyId) {
    document.getElementById('deleteConfirm-' + storyId).style.display = 'block';
}

function closeDeleteConfirm(storyId) {
    document.getElementById('deleteConfirm-' + storyId).style.display = 'none';
}
</script>

<?php include 'footer.php'; ?>
</body>
</html>
