<?php

require 'database.php';

$mysqli = require __DIR__ . "/database.php";
if (!isset($_GET['building_id'])) {
    die("No selected building/room.");
}
$_SESSION['building_id'] = $_GET['building_id'];
$building_id = $_SESSION['building_id'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM npcs WHERE building_id = ? AND user_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ii', $building_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$npc_notes = $result->fetch_assoc();
$stmt->close();

include 'place_redirect.php';

$mysqli->close();

?>


<div class="npcs">
<button onclick="toggleNpcForm()">Edit</button>
    <h3 class="npc-name"><b><?php echo htmlspecialchars($npc_notes['npc_name'] ?? 'No description available.'); ?></b></h3>
    <div class="npc-class">
        <p><?php echo htmlspecialchars($npc_notes['npc_class'] ?? 'No description available.'); ?> | <?php echo htmlspecialchars($npc_notes['npc_race'] ?? 'No description available.'); ?></p>
    </div>
    <div class="npc-stats">
        <div class="stat">
            <h2><?php echo htmlspecialchars($npc_notes['Strenght'] ?? ' '); ?></h2>
            <p>STR</p>
        </div>
        <div class="stat">
            <h2><?php echo htmlspecialchars($npc_notes['Dexterity'] ?? ' '); ?></h2>
            <p>DEX</p>
        </div>
        <div class="stat">
            <h2><?php echo htmlspecialchars($npc_notes['Constitution'] ?? ' '); ?></h2>
            <p>CON</p>
        </div>
        <div class="stat">
            <h2><?php echo htmlspecialchars($npc_notes['Intelligence'] ?? ' '); ?></h2>
            <p>INT</p>
        </div>
        <div class="stat">
            <h2><?php echo htmlspecialchars($npc_notes['Wisdom'] ?? ' '); ?></h2>
            <p>WIS</p>
        </div>
        <div class="stat">
            <h2><?php echo htmlspecialchars($npc_notes['Charisma'] ?? ' '); ?></h2>
            <p>CHA</p>
        </div>
    </div>
    <div class="npc-abilities">
        <p><?php echo htmlspecialchars($npc_notes['npc_abilities'] ?? 'No description available.'); ?></p>
    </div>
    <div class="npc-description">
        <p><?php echo htmlspecialchars($npc_notes['npc_description'] ?? 'No description available.'); ?></p>
    </div>
</div>

<div id="npcForm" class="edit-form">
    <form method="post">
        <label for="npc_name"><h3>NPC's name:</h3></label>
        <input type="text" id="npc_name" name="npc_name" value="<?php echo htmlspecialchars($npc_notes['npc_name'] ?? ''); ?>">

        <label for="npc_class"><h3>Class:</h3></label>
        <input type="text" id="npc_class" name="npc_class" value="<?php echo htmlspecialchars($npc_notes['npc_class'] ?? ''); ?>">


        <label for="npc_race"><h3>Race:</h3></label>
        <input type="text" id="npc_race" name="npc_race" value="<?php echo htmlspecialchars($npc_notes['npc_race'] ?? ''); ?>">

        <label for="Strenght"><h3>STR:</h3></label>
        <input type="number" id="Strenght" name="Strenght" min="1" max="25" value="<?php echo htmlspecialchars($npc_notes['Strenght'] ?? ''); ?>">

        <label for="Dexterity"><h3>DEX:</h3></label>
        <input type="number" id="Dexterity" name="Dexterity" min="1" max="25" value="<?php echo htmlspecialchars($npc_notes['Dexterity'] ?? ''); ?>">

        <label for="Constitution"><h3>CON:</h3></label>
        <input type="number" id="Constitution" name="Constitution" min="1" max="25" value="<?php echo htmlspecialchars($npc_notes['Constitution'] ?? ''); ?>">

        <label for="Intelligence"><h3>INT:</h3></label>
        <input type="number" id="Intelligence" name="Intelligence" min="1" max="25" value="<?php echo htmlspecialchars($npc_notes['Intelligence'] ?? ''); ?>">

        <label for="Wisdom"><h3>WIS:</h3></label>
        <input type="number" id="Wisdom" name="Wisdom" min="1" max="25" value="<?php echo htmlspecialchars($npc_notes['Wisdom'] ?? ''); ?>">

        <label for="Charisma"><h3>CHA:</h3></label>
        <input type="number" id="Charisma" name="Charisma" min="1" max="25" value="<?php echo htmlspecialchars($npc_notes['Charisma'] ?? ''); ?>">

        <label for="npc_abilities"><h2>Abilities:</h2></label>
        <textarea name="npc_abilities" id="npc_abilities" rows="10" cols="50">
            <?php echo htmlspecialchars($notes['npc_abilities'] ?? ''); ?>
        </textarea>
        
        <label for="npc_description"><h2>Description:</h2></label>
        <textarea name="npc_description" id="npc_description" rows="10" cols="50">
            <?php echo htmlspecialchars($notes['npc_description'] ?? ''); ?>
        </textarea>

        <button type="submit" name="save_npc_changes">Save Changes</button>
        <button type="button" onclick="toggleNpcForm()">Cancel</button>
    </form>
</div>

<script>
    function toggleNpcForm() {
        var form = document.getElementById('npcForm');
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
</script>