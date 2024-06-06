<?php
require 'database.php';

$mysqli = require __DIR__ . "/database.php";

if (!isset($_GET['region_id'])) {
    die("Region ID is required.");
}
$region_id = $_GET['region_id'];

include 'place_redirect.php';

// Fetch place details
$sql = "SELECT * FROM places WHERE region_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $region_id);
$stmt->execute();
$result = $stmt->get_result();
?>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="place-card">
            <h2><?php echo htmlspecialchars($row['place_name']); ?></h2>
            <p><?php echo htmlspecialchars($row['tags']); ?></p>
            <a href="place_dashboard.php?place_id=<?php echo $row['id']; ?>">View Details</a>
            <button onclick="openEditForm(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['place_name']); ?>', '<?php echo htmlspecialchars($row['tags']); ?>')">Edit</button>
            <button onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete</button>
        </div>
    <?php endwhile; ?>

<div id="editPlaceForm" style="display: none; color: #fff;" class="blur-box">
    <form method="post" id="editForm">
        <input type="hidden" name="place_id" id="editPlaceId">
        <label for="edit_place_name"><h2>Edit Place Name:</h2></label>
        <input type="text" name="edit_place_name" id="editPlaceName" required>
        <label for="edit_place_tags"><h2>Edit Tags:</h2></label>
        <input type="text" name="edit_place_tags" id="editPlaceTags" required>
        <button type="submit" name="edit_place">Save Changes</button>
    </form>
</div>

<form method="post" id="deleteForm" style="display: none;">
    <input type="hidden" name="place_id" id="deletePlaceId">
    <button type="submit" name="delete_place"></button>
</form>

<script>
    function openEditForm(placeId, placeName, placeTags) {
        document.getElementById('editPlaceId').value = placeId;
        document.getElementById('editPlaceName').value = placeName;
        document.getElementById('editPlaceTags').value = placeTags;
        document.getElementById('editPlaceForm').style.display = 'block';
    }

    function confirmDelete(placeId) {
        var result = confirm("Are you sure you want to delete this place?");
        if (result) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'places.php?region_id=<?php echo $region_id; ?>';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'place_id';
            input.value = placeId;

            var deleteInput = document.createElement('input');
            deleteInput.type = 'hidden';
            deleteInput.name = 'delete_place';

            form.appendChild(input);
            form.appendChild(deleteInput);
            document.body.appendChild(form);
            form.submit();
        } else {
            window.location.href = 'places.php?region_id=<?php echo $region_id; ?>';
        }
    }
</script>

<?php
$stmt->close();
$mysqli->close();
?>
