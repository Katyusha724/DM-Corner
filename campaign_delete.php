<?php
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_campaign'])) {
    $mysqli = require __DIR__ . "/database.php";

    $campaign_id = $_POST['campaign_id'];

    $sql = "DELETE FROM campaigns WHERE id = ? AND user_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii', $campaign_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        header('Location: index-log.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $campaign_id = $_POST['campaign_id'];
    header("Location: players.php?campaign_id=$campaign_id");
    
    $stmt->close();
    $mysqli->close();
}
?>
