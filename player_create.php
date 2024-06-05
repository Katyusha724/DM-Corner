<?php
require 'database.php'; 
// Fetch user ID from session
$user_id = $_SESSION['user_id'];


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_player'])) {
    $mysqli = require __DIR__ . "/database.php";

    $campaign_id = $_SESSION['campaign_id'];
    // Escape and sanitize input data
    $player_name = $mysqli->real_escape_string($_POST['player_name']);
    $character_name = $mysqli->real_escape_string($_POST['character_name']);
    $player_class = $mysqli->real_escape_string($_POST['player_class']);
    $player_subclass = $mysqli->real_escape_string($_POST['player_subclass']);
    $player_race = $mysqli->real_escape_string($_POST['player_race']);
    $hp = $mysqli->real_escape_string($_POST['hp']);
    $AC = $mysqli->real_escape_string($_POST['AC']);
    $passive_perception = $mysqli->real_escape_string($_POST['passive_perception']);

    // Prepare and execute SQL query to insert player
    $sql = "INSERT INTO players (user_id, campaign_id, player_name, character_name, player_class, player_subclass, player_race, hp, AC, passive_perception) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iisssssiii', $user_id, $campaign_id, $player_name, $character_name, $player_class, $player_subclass, $player_race, $hp, $AC, $passive_perception);
    
    if ($stmt->execute()) {
        header("Location: players.php?campaign_id=$campaign_id"); 
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}

?>

<h1>Add a player</h1>
    <div class="triple-diamond-deco-container">
        <div class="left-line"></div>
        <div class="right-line"></div>
        <div class="small-diamond-left"></div>
        <div class="small-diamond-right"></div>
        <div class="large-diamond"></div>
    </div>
<form method="post">
    
    <label for="player_name">Player's Name:</label>
    <input type="text" name="player_name" id="player_name" required>
    
    <label for="character_name">Character Name:</label>
    <input type="text" name="character_name" id="character_name" required>

    <label for="player_class">Class:</label>
    <input type="text" name="player_class" id="player_class">

    <label for="player_subclass">Subclass:</label>
    <input type="text" name="player_subclass" id="player_subclass">

    <label for="player_race">Race:</label>
    <input type="text" name="player_race" id="player_race">

    <label for="hp">HP:</label>
    <input type="number" name="hp" id="hp">

    <label for="AC">Armour Class:</label>
    <input type="number" name="AC" id="AC">

    <label for="passive_perception">Passive Perception:</label>
    <input type="number" name="passive_perception" id="passive_perception">
    
    <button type="submit" name="add_player">Add Player</button>
</form>
