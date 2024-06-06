<?php
require 'database.php'; 

$mysqli = require __DIR__ . "/database.php"; 

include 'place_redirect.php';

if (!isset($place_id)) {
    die("Place ID is required.");
}
$place_id = $_SESSION['place_id'];

// Fetch buildings
$sql = "SELECT id, building_name FROM buildings WHERE place_id = ?";
$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $mysqli->error);
}
$stmt->bind_param('i', $place_id);
$stmt->execute();
$building_result = $stmt->get_result();
$buildings = $building_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$mysqli->close();
?>

<div class="buildings-list">
    <ul>
        <?php foreach ($buildings as $building): ?>
            <li class="loot-item">
                <a href="place_dashboard.php?place_id=<?php echo $place_id; ?>&building_id=<?php echo $building['id']; ?>">
                    <?php echo htmlspecialchars($building['building_name']); ?>
                </a>
                <button onclick="openEditForm(<?php echo $building['id']; ?>, '<?php echo htmlspecialchars($building['building_name']); ?>')">Edit</button>
                <button onclick="confirmDelete(<?php echo $building['id']; ?>)">Delete</button>
            </li>
        <?php endforeach; ?>
    </ul>

    <div id="addBuildingForm" style="display: none; color: #fff;" class="blur-box">
        <form method="post">
            <label for="building_name"><h2>Building Name:</h2></label>
            <input type="text" name="building_name" required>
            <button type="submit" name="create_building">Add new building</button>
        </form>
    </div>

    <div id="editBuildingForm" style="display: none; color: #fff;" class="blur-box">
        <form method="post" id="editForm">
            <input type="hidden" name="building_id" id="editBuildingId">
            <label for="edit_building_name"><h2>Edit Building Name:</h2></label>
            <input type="text" name="edit_building_name" id="editBuildingName" required>
            <button type="submit" name="edit_building">Save Changes</button>
        </form>
    </div>

    <form method="post" id="deleteForm" style="display: none;">
        <input type="hidden" name="building_id" id="deleteBuildingId">
        <button type="submit" name="delete_building"></button>
    </form>
</div>

<script>
    function openAddBuildingForm() {
        document.getElementById('addBuildingForm').style.display = 'block';
    }

    function openEditForm(buildingId, buildingName) {
        document.getElementById('editBuildingId').value = buildingId;
        document.getElementById('editBuildingName').value = buildingName;
        document.getElementById('editBuildingForm').style.display = 'block';
    }

    function confirmDelete(buildingId) {
        var result = confirm("Are you sure you want to delete this building?");
        if (result) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'place_redirect.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'building_id';
            input.value = buildingId;

            var placeInput = document.createElement('input');
            placeInput.type = 'hidden';
            placeInput.name = 'place_id';
            placeInput.value = '<?php echo $place_id; ?>';

            form.appendChild(input);
            form.appendChild(placeInput);
            document.body.appendChild(form);
            form.submit();
        } else {
            window.location.href = 'place_dashboard.php?place_id=<?php echo $place_id; ?>';
        }
    }
</script>
