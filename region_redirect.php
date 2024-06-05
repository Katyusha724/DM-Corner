<?php
ob_start();
require 'database.php';

$redirectUrl = null;

$mysqli = require __DIR__ . "/database.php"; // Initialize $mysqli

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_region'])) {
        // Code for creating a new region
        $campaign_id = $_SESSION['campaign_id'];
        $region_name = $mysqli->real_escape_string($_POST['region_name']);
        $basic_info = $mysqli->real_escape_string($_POST['basic_info']);
        $lore = $mysqli->real_escape_string($_POST['lore']);

        $sql = "INSERT INTO regions (user_id, campaign_id, region_name, basic_info, lore) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }
        $stmt->bind_param('iisss', $user_id, $campaign_id, $region_name, $basic_info, $lore);

        if ($stmt->execute()) {
            $redirectUrl = "regions.php?campaign_id=$campaign_id";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();

    } elseif (isset($_POST['edit_region'])) {
        // Code for editing a region
        $region_id = $_POST['region_id'];
        $region_name = $mysqli->real_escape_string($_POST['edit_region_name']);
        $basic_info = $mysqli->real_escape_string($_POST['edit_basic_info']);
        $lore = $mysqli->real_escape_string($_POST['edit_lore']);

        $sql = "UPDATE regions SET region_name = ?, basic_info = ?, lore = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }
        $stmt->bind_param('sssi', $region_name, $basic_info, $lore, $region_id);
        $stmt->execute();
        $stmt->close();

        $redirectUrl = "regions.php?campaign_id=$campaign_id";

    } elseif (isset($_POST['delete_region'])) {
        // Code for deleting a region
        $region_id = $_POST['region_id'];

        $sql = "DELETE FROM regions WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }
        $stmt->bind_param('i', $region_id);
        $stmt->execute();
        $stmt->close();

        $redirectUrl = "regions.php?campaign_id=$campaign_id";
    }

    if ($redirectUrl) {
        header("Location: $redirectUrl");
        exit();
    }
}

ob_end_flush();
?>
