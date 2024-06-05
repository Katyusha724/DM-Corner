<?php
session_start();
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_story'])) {
    $story_id = $_POST['story_id'];
    $campaign_id = $_POST['campaign_id'];

    $mysqli = require __DIR__ . "/database.php";

    $sql = "DELETE FROM story WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $story_id);

    if ($stmt->execute()) {
        header("Location: story_view.php?campaign_id=$campaign_id");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
