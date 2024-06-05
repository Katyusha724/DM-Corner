<?php
require 'database.php';
$mysqli = require __DIR__ . "/database.php";

$campaign_id = $_SESSION['campaign_id'];
// Fetch region details
$sql = "SELECT * FROM players WHERE campaign_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $campaign_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo '<div class="player-card-1">';
    echo '<h2>' . htmlspecialchars($row['character_name']) . '</h2>';
    echo '<hr><p><b>' . htmlspecialchars($row['player_class']) . ' | ' . htmlspecialchars($row['player_subclass']) .'</b></p>';
    echo '<hr><p>' . htmlspecialchars($row['player_race']) . '</p>';
    echo '<hr><div class="row"><p><b> HP: </b>' . htmlspecialchars($row['hp']) . '</p>';
    echo '<p><b> AC: </b>' . htmlspecialchars($row['AC']) . '</p> </div>';
    echo '<p><b> Passive Perception: </b>' . htmlspecialchars($row['passive_perception']) . '</p>';
    echo '<hr><p><b>Player: </b>' . htmlspecialchars($row['player_name']) . '</p>';
    echo '<button onclick="editPlayer(' . $row['id'] . ')">Edit</button>';
    echo '<button onclick="confirmDelete(' . $row['id'] . ')">Delete</button>';
    echo '</div>';

    // Edit form (initially hidden)
    echo '<div id="editForm' . $row['id'] . '" style="display:none;" class="edit-form">';
    echo '<form action="player_update.php" method="post">';
    echo '<input type="hidden" name="player_id" value="' . $row['id'] . '">';
    echo '<input type="hidden" name="campaign_id" value="' . $campaign_id . '">';
    echo '<label for="character_name">Character Name: </label>';
    echo '<input type="text" name="character_name" value="' . htmlspecialchars($row['character_name']) . '">';
    echo '<label for="player_class">Class: </label>';
    echo '<input type="text" name="player_class" value="' . htmlspecialchars($row['player_class']) . '">';
    echo '<label for="player_subclass">Subclass: </label>';
    echo '<input type="text" name="player_subclass" value="' . htmlspecialchars($row['player_subclass']) . '">';
    echo '<label for="player_race">Race: </label>';
    echo '<input type="text" name="player_race" value="' . htmlspecialchars($row['player_race']) . '">';
    echo '<label for="hp">HP: </label>';
    echo '<input type="number" name="hp" value="' . htmlspecialchars($row['hp']) . '">';
    echo '<label for="AC">AC: </label>';
    echo '<input type="number" name="AC" value="' . htmlspecialchars($row['AC']) . '">';
    echo '<label for="passive_perception">Passive Perception: </label>';
    echo '<input type="number" name="passive_perception" value="' . htmlspecialchars($row['passive_perception']) . '">';
    echo '<label for="player_name">Player Name: </label>';
    echo '<input type="text" name="player_name" value="' . htmlspecialchars($row['player_name']) . '">';
    echo '<button type="submit">Save</button>';
    echo '<button type="button" onclick="cancelEdit(' . $row['id'] . ')">Cancel</button>';
    echo '</form>';
    echo '</div>';
}

$stmt->close();
$mysqli->close();
?>

<script>
function editPlayer(playerId) {
    document.getElementById('editForm' + playerId).style.display = 'block';
}

function cancelEdit(playerId) {
    document.getElementById('editForm' + playerId).style.display = 'none';
}

function confirmDelete(playerId) {
    var result = confirm("Are you sure you want to delete this player?");
    if (result) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = 'player_delete.php';

        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'player_id';
        input.value = playerId;

        var campaignInput = document.createElement('input');
        campaignInput.type = 'hidden';
        campaignInput.name = 'campaign_id';
        campaignInput.value = '<?php echo $campaign_id; ?>';

        form.appendChild(input);
        form.appendChild(campaignInput);
        document.body.appendChild(form);
        form.submit();
    } else {
        window.location.href = 'players.php?campaign_id=<?php echo $campaign_id; ?>';
    }
}

</script>
