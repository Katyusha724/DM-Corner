<?php
require 'database.php';
$user_id = $_SESSION['user_id'];

// Fetch Campaign Name
$campaign_name = 'Campaign';
if (isset($_SESSION['campaign_id'])) {
    $campaign_id = $_SESSION['campaign_id'];
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT name FROM campaigns WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $campaign_id);
    $stmt->execute();
    $stmt->bind_result($campaign_name);
    $stmt->fetch();
    $stmt->close();
}

// Fetch Region Name
$region_name = 'Region';
if (isset($_SESSION['region_id'])) {
    $region_id = $_SESSION['region_id'];
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT region_name FROM regions WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $region_id);
    $stmt->execute();
    $stmt->bind_result($region_name);
    $stmt->fetch();
    $stmt->close();
}

// Fetch Place Name
$place_name = 'Place';
if (isset($_SESSION['place_id'])) {
    $place_id = $_SESSION['place_id'];
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT place_name FROM places WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $place_id);
    $stmt->execute();
    $stmt->bind_result($place_name);
    $stmt->fetch();
    $stmt->close();
}

$mysqli->close();
?>
