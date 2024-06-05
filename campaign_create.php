<?php
require 'database.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['create_campaign'])) {
    $mysqli = require __DIR__ . "/database.php";

    $user_id = $_SESSION['user_id'];
    $name = $mysqli->real_escape_string($_POST['name']);
    $description = $mysqli->real_escape_string($_POST['description']);
    $background_color = $_POST['background_color']; // Get the background color

    $sql = "INSERT INTO campaigns (user_id, name, description, background_color) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('isss', $user_id, $name, $description, $background_color);
    
    if ($stmt->execute()) {
        header('Location: index-log.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>

<form method="post">
    <label for="name">Campaign Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>

    <label for="background_color">Background Color:</label>
    <input type="color" name="background_color" id="background_color" value="#ffffff">

    <button type="submit" name="create_campaign">Create Campaign</button>
</form>