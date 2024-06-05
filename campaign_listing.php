<?php
require 'database.php'; 

$mysqli = require __DIR__ . "/database.php";
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_campaign'])) {
    $campaign_id = $_POST['campaign_id'];
    
    $delete_sql = "DELETE FROM campaigns WHERE id = ? AND user_id = ?";
    $delete_stmt = $mysqli->prepare($delete_sql);
    $delete_stmt->bind_param('ii', $campaign_id, $user_id);
    
    if ($delete_stmt->execute()) {
        echo "<h4>Campaign deleted successfully.</h4><br>";
    } else {
        echo "Error deleting campaign: " . $delete_stmt->error;
    }
    
    $delete_stmt->close();
}

// Fetch and display campaigns
$sql = "SELECT * FROM campaigns WHERE user_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $background_color = htmlspecialchars($row['background_color']);
    echo '<br><div class="campaign-card" style="background-color: ' . $background_color . ';">';
    echo '<h2>' . htmlspecialchars($row['name']) . '</h2>';
    echo '<hr><p>' . htmlspecialchars($row['description']) . '</p>';
    echo '<hr><a class="link" href="campaign_home.php?id=' . $row['id'] . '">View Details</a>';
    echo '<form method="post">';
    echo '<input type="hidden" name="campaign_id" value="' . $row['id'] . '">';
    echo '<button type="submit" name="delete_campaign">Delete</button>';
    echo '</form>';
    echo '</div>';
}

$stmt->close();
$mysqli->close();
?>