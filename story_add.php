<?php
session_start();
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_story'])) {
    $campaign_id = $_POST['campaign_id'];
    $section_title = $_POST['section_title'];
    $content = $_POST['content'];

    $mysqli = require __DIR__ . "/database.php";

    $sql = "INSERT INTO story (campaign_id, section_title, content) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iss', $campaign_id, $section_title, $content);
    
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
