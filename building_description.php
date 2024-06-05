<?php
require 'database.php';

$mysqli = require __DIR__ . "/database.php";

if (!isset($_GET['building_id'])) {
    die("No selected building.");
}

$_SESSION['building_id'] = $_GET['building_id'];
$building_id = $_SESSION['building_id'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM buildings WHERE id = ? AND place_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ii', $building_id, $place_id);
$stmt->execute();
$result = $stmt->get_result();
$building = $result->fetch_assoc();
$stmt->close();

include 'place_redirect.php';

$mysqli->close();
?>

<div class="building-description">
    <button onclick="toggleBuildingForm()">Edit</button>
    <h2><?php echo htmlspecialchars($building['building_name'] ?? 'No description available.'); ?></h2>
    <div class="description">
        <p><?php echo nl2br(htmlspecialchars($building['description'] ?? 'No description available.')); ?></p>
    </div>
</div>

<div id="buildingForm" class="edit-form" style="display: none;">
    <form method="post" action="building_update.php">
        <label for="building_description"><h3>Building Description:</h3></label>
        <textarea name="building_description" id="building_description" rows="10" cols="50"><?php echo htmlspecialchars($building['description'] ?? ''); ?></textarea>
        <button type="submit" name="save_building_changes">Save Changes</button>
        <button type="button" onclick="toggleBuildingForm()">Cancel</button>
    </form>
</div>

<script>
    function toggleBuildingForm() {
        var form = document.getElementById('buildingForm');
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
</script>
