<?php
require 'database.php';

if (!isset($_POST['session_id']) || !isset($_POST['campaign_id']) || !isset($_POST['session_name'])) {
    die("Session ID, Campaign ID, and Session Name are required.");
}

$session_id = $_POST['session_id'];
$campaign_id = $_POST['campaign_id'];
$session_name = $_POST['session_name'];
$notes = $_POST['notes'];
$bullet_points = $_POST['bullet_points'];
$place_id = $_POST['place_id'];
$mysqli = require __DIR__ . "/database.php";

$sql = "UPDATE sessions SET session_name = ?, notes = ?, bullet_points = ? WHERE id = ? AND campaign_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('sssii', $session_name, $notes, $bullet_points, $session_id, $campaign_id);
$stmt->execute();
$stmt->close();

header("Location: sessions.php?campaign_id=$campaign_id&session_id=$session_id");
?>
