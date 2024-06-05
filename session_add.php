<?php
require 'database.php';

if (!isset($_POST['campaign_id']) || !isset($_POST['session_name'])) {
    die("Campaign ID and Session Name are required.");
}

$campaign_id = $_POST['campaign_id'];
$session_name = $_POST['session_name'];
$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT COALESCE(MAX(session_number), 0) + 1 AS new_session_number FROM sessions WHERE campaign_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $campaign_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$session_number = $row['new_session_number'];
$stmt->close();

$sql = "INSERT INTO sessions (campaign_id, session_number, session_name) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('iis', $campaign_id, $session_number, $session_name);
$stmt->execute();
$stmt->close();

header("Location: sessions.php?campaign_id=$campaign_id");
?>
