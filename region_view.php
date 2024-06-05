<?php
require 'database.php';

$mysqli = require __DIR__ . "/database.php";

include 'region_redirect.php';

$campaign_id = $_SESSION['campaign_id'];
// Fetch region details
$sql = "SELECT * FROM regions WHERE campaign_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $campaign_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo '<div class="region-card-1">';
    echo '<h2>' . htmlspecialchars($row['region_name']) . '</h2>';
    echo '<p>' . htmlspecialchars($row['basic_info']) . '</p>';
    echo '<a href="places.php?region_id=' . $row['id'] . '">View Details</a>';
    
    // Edit and Delete buttons
    echo '<button onclick="openEditForm(' . $row['id'] . ', \'' . htmlspecialchars($row['region_name']) . '\', \'' . htmlspecialchars($row['basic_info']) . '\', \'' . htmlspecialchars($row['lore']) . '\')">Edit</button>';
    echo '<button onclick="confirmDelete(' . $row['id'] . ')">Delete</button>';

    echo '</div>';
}

$stmt->close();
$mysqli->close();
?>

<!-- Edit Form -->
<div id="editForm" style="display: none; color: #fff;" class="blur-box">
    <form method="post" action="region_redirect.php">
        <input type="hidden" name="region_id" id="edit_region_id">
        <label for="edit_region_name"><h2>Region Name:</h2></label>
        <input type="text" name="edit_region_name" id="edit_region_name">
        <label for="edit_basic_info"><h2>Basic Info:</h2></label>
        <textarea name="edit_basic_info" id="edit_basic_info"></textarea>
        <label for="edit_lore"><h2>Lore:</h2></label>
        <textarea name="edit_lore" id="edit_lore"></textarea>
        <button type="submit" name="edit_region">Save Changes</button>
    </form>
</div>

<script>
    function openEditForm(regionId, regionName, basicInfo, lore) {
        document.getElementById('edit_region_id').value = regionId;
        document.getElementById('edit_region_name').value = regionName;
        document.getElementById('edit_basic_info').value = basicInfo;
        document.getElementById('edit_lore').value = lore;
        document.getElementById('editForm').style.display = 'block';
    }

    function confirmDelete(regionId) {
        var result = confirm("Are you sure you want to delete this region?");
        if (result) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'region_redirect.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'region_id';
            input.value = regionId;

            var deleteInput = document.createElement('input');
            deleteInput.type = 'hidden';
            deleteInput.name = 'delete_region';
            deleteInput.value = true;

            form.appendChild(input);
            form.appendChild(deleteInput);
            document.body.appendChild(form);
            form.submit();
        } else {
            window.location.href = 'regions.php?campaign_id=<?php echo $campaign_id; ?>';
        }
    }
</script>
