<?php
session_start();
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_story'])) {
    $story_id = $_POST['story_id'];
    $campaign_id = $_POST['campaign_id'];
    $section_title = $_POST['section_title'];
    $content = $_POST['content'];

    $mysqli = require __DIR__ . "/database.php";

    $sql = "UPDATE story SET section_title = ?, content = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssi', $section_title, $content, $story_id);

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
