<?php
require 'database.php'; 
// Fetch user ID from session
$user_id = $_SESSION['user_id'];
include 'region_redirect.php';

?>

<h1>Create Region</h1>
    <div class="triple-diamond-deco-container">
        <div class="left-line"></div>
        <div class="right-line"></div>
        <div class="small-diamond-left"></div>
        <div class="small-diamond-right"></div>
        <div class="large-diamond"></div>
    </div>
<form method="post" enctype="multipart/form-data">
    <!-- Campaign ID is fetched automatically -->
    
    <label for="region_name">Region Name:</label>
    <input type="text" name="region_name" id="region_name" required>
    
    <label for="basic_info">Basic Info:</label>
    <textarea name="basic_info" id="basic_info" placeholder="e.g., ruler, races, religion, etc." required></textarea>
    
    <label for="lore">Lore:</label>
    <textarea name="lore" id="lore"></textarea>
    
    <button type="submit" name="create_region">Create Region</button>
</form>


    
