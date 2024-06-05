<?php

require 'database.php';

$mysqli = require __DIR__ . "/database.php";
if (!isset($_GET['building_id'])) {
    die("No selected building/room.");
}
$_SESSION['building_id'] = $_GET['building_id'];
$building_id = $_SESSION['building_id'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM quests WHERE building_id = ? AND user_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ii', $building_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$quest_notes = $result->fetch_assoc();
$stmt->close();

include 'place_redirect.php';

$mysqli->close();

?>


<div class="quests">
    <button onclick="toggleQuestForm()">Edit</button>
    <h2 class="quest-name"><b><?php echo htmlspecialchars($quest_notes['quest_name'] ?? 'No description available.'); ?></b></h2>
    <div class="quest-description">
        <p><b>Goal:</b> <?php echo htmlspecialchars($quest_notes['goal'] ?? 'No description available.'); ?></p>
        <p><b>NPC:</b> <?php echo htmlspecialchars($quest_notes['npc'] ?? 'No description available.'); ?></p>
        <p><b>Place:</b> <?php echo htmlspecialchars($quest_notes['place'] ?? 'No description available.'); ?></p>
        <p><?php echo nl2br(htmlspecialchars($quest_notes['description'] ?? 'No description available.')); ?></p>
    </div>
    <h2>Reward:</h2>
    <div class="loot-list">
        <div class="loot-item">
            <div>
                <h3 class="loot-name"><?php echo htmlspecialchars($quest_notes['reward_name'] ?? 'No description available.'); ?></h3>
                
            </div>
            <h2 class="loot-price"><?php echo htmlspecialchars($quest_notes['reward_price'] ?? 'No description available.'); ?></h2>
             
        </div><div class="loot-description">
                <p><?php echo htmlspecialchars($quest_notes['reward_description'] ?? 'No description available.'); ?></p>
            </div> 
    </div>
</div>

<div id="questForm" class="edit-form">
    <form method="post">
        <label for="quest_name"><h3>Quest Name:</h3></label>
        <input type="text" id="quest_name" name="quest_name" value="<?php echo htmlspecialchars($quest_notes['quest_name'] ?? ''); ?>">

        <label for="goal"><h3>Goal:</h3></label>
        <input type="text" id="goal" name="goal" value="<?php echo htmlspecialchars($quest_notes['goal'] ?? ''); ?>">

        <label for="npc"><h3>NPC:</h3></label>
        <input type="text" id="npc" name="npc" value="<?php echo htmlspecialchars($quest_notes['npc'] ?? ''); ?>">

        <label for="place"><h3>Place:</h3></label>
        <input type="text" id="place" name="place" value="<?php echo htmlspecialchars($quest_notes['place'] ?? ''); ?>">

        <label for="description"><h3>Description:</h3></label>
        <textarea name="description" id="description" rows="10" cols="50"><?php echo htmlspecialchars($quest_notes['description'] ?? ''); ?></textarea>

        <label for="reward_name"><h2>Reward Name:</h2></label>
        <input type="text" id="reward_name" name="reward_name" value="<?php echo htmlspecialchars($quest_notes['reward_name'] ?? ''); ?>">

        <label for="reward_description"><h2>Reward Description:</h2></label>
        <textarea name="reward_description" id="reward_description" rows="10" cols="50"><?php echo htmlspecialchars($quest_notes['reward_description'] ?? ''); ?></textarea>

        <label for="reward_price"><h2>Reward Price:</h2></label>
        <input type="text" id="reward_price" name="reward_price" value="<?php echo htmlspecialchars($quest_notes['reward_price'] ?? ''); ?>">

        <button type="submit" name="save_quest_changes">Save Changes</button>
        <button type="button" onclick="toggleQuestForm()">Cancel</button>
    </form>
</div>

<script>
    function toggleQuestForm() {
        var form = document.getElementById('questForm');
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
</script>

