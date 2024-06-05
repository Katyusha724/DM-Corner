<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $player_id = $_POST['player_id'];
    $campaign_id = $_POST['campaign_id'];

    $mysqli = require __DIR__ . "/database.php";

    $sql = "DELETE FROM players WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $player_id);
    $stmt->execute();
    $stmt->close();

    $mysqli->close();

    header("Location: players.php?campaign_id=$campaign_id");
    exit();
}
?>
