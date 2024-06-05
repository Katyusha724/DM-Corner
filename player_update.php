<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $player_id = $_POST['player_id'];
    $campaign_id = $_POST['campaign_id'];
    $character_name = $_POST['character_name'];
    $player_class = $_POST['player_class'];
    $player_subclass = $_POST['player_subclass'];
    $player_race = $_POST['player_race'];
    $hp = $_POST['hp'];
    $AC = $_POST['AC'];
    $passive_perception = $_POST['passive_perception'];
    $player_name = $_POST['player_name'];

    $mysqli = require __DIR__ . "/database.php";

    $sql = "UPDATE players SET character_name = ?, player_class = ?, player_subclass = ?, player_race = ?, hp = ?, AC = ?, passive_perception = ?, player_name = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssssiiisi', $character_name, $player_class, $player_subclass, $player_race, $hp, $AC, $passive_perception, $player_name, $player_id);
    $stmt->execute();
    $stmt->close();

    $mysqli->close();

    header("Location: players.php?campaign_id=$campaign_id");
    exit();
}
?>
