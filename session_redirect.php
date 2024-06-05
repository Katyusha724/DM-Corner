<?php
ob_start();
require 'database.php';

$redirectUrl = null;

$mysqli = require __DIR__ . "/database.php"; // Initialize $mysqli

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_session'])) {
        // Code for deleting a session
        $session_id = $_POST['session_id'];
        $campaign_id = $_POST['campaign_id'];

        $sql = "DELETE FROM sessions WHERE id = ? AND campaign_id = ?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }
        $stmt->bind_param('ii', $session_id, $campaign_id);
        $stmt->execute();
        $stmt->close();

        $redirectUrl = "sessions.php?campaign_id=$campaign_id";
    }

    if ($redirectUrl) {
        header("Location: $redirectUrl");
        exit();
    }
}

ob_end_flush();
?>
