<?php
require 'database.php';

$mysqli = require __DIR__ . "/database.php";
$place_id = $_GET['place_id'];
$user_id = $_SESSION['user_id'];

include 'place_redirect.php';
$mysqli->close();
?>

<div class="card-head">
        <h1><?php echo htmlspecialchars($place['place_name']); ?></h1>
        <button onclick="toggleEditForm()">Edit</button>
    </div>
    <div class="card-body-1">
        <p><b>Tags: <?php echo htmlspecialchars($place['tags']); ?></b></p> <br>
        <div class="basic-info">
            <p><?php echo htmlspecialchars($notes['basic_info'] ?? 'No basic info available.'); ?></p>
        </div>
        
        <div class="triple-diamond-deco-container">
            <div class="left-line"></div>
            <div class="right-line"></div>
            <div class="small-diamond-left"></div>
            <div class="small-diamond-right"></div>
            <div class="large-diamond"></div>
        </div>

        <h2>Description</h2>
        <div class="description">
            <p><?php echo htmlspecialchars($notes['description'] ?? 'No description available.'); ?></p>
        </div>
        
        <div class="triple-diamond-deco-container">
            <div class="left-line"></div>
            <div class="right-line"></div>
            <div class="small-diamond-left"></div>
            <div class="small-diamond-right"></div>
            <div class="large-diamond"></div>
        </div>

        <h2>DM Notes</h2>
        <div class="dm-notes">
            <p><?php echo htmlspecialchars($notes['dm_notes'] ?? 'No DM notes available.'); ?></p>
        </div>
        
        <div class="triple-diamond-deco-container">
            <div class="left-line"></div>
            <div class="right-line"></div>
            <div class="small-diamond-left"></div>
            <div class="small-diamond-right"></div>
            <div class="large-diamond"></div>
        </div>

        <h2>Point of interests</h2>
        <div class="point-of-interests">
            <p><?php echo htmlspecialchars($notes['points_of_interest'] ?? 'No points of interest available.'); ?></p>
        </div>
    </div>
    <div id="editForm" class="edit-form">
        <form method="post">
            <label for="basic_info"><h2>Basic Info:</h2></label>
            <textarea name="basic_info" id="basic_info"><?php echo htmlspecialchars($notes['basic_info'] ?? ''); ?></textarea>
            <label for="description"><h2>Description:</h2></label>
            <textarea name="description" id="description"><?php echo htmlspecialchars($notes['description'] ?? ''); ?></textarea>
            <label for="dm_notes"><h2>DM Notes:</h2></label>
            <textarea name="dm_notes" id="dm_notes"><?php echo htmlspecialchars($notes['dm_notes'] ?? ''); ?></textarea>
            <label for="points_of_interest"><h2>Points of Interest:</h2></label>
            <textarea name="points_of_interest" id="points_of_interest"><?php echo htmlspecialchars($notes['points_of_interest'] ?? ''); ?></textarea>
            <button type="submit" name="save_changes">Save Changes</button>
            <button type="button" onclick="toggleEditForm()">Cancel</button>
        </form>
    </div>

<script>
    function toggleEditForm() {
        var form = document.getElementById('editForm');
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
</script>


