<?php
require 'database.php';
$user_id = $_SESSION['user_id'];
include 'place_redirect.php';

?>
    <form method="post">
        <label for="place_name">Name of Place:</label>
        <input type="text" name="place_name" id="place_name" required>
        
        <label>Tags:</label><br><br>
        <label class="checkbox-container">
            <input type="checkbox" name="tags[]" value="Town"> Town
            <span class="checkmark"></span>
        </label>

        <label class="checkbox-container">
            <input type="checkbox" name="tags[]" value="Capital"> Capital
            <span class="checkmark"></span>
        </label>

        <label class="checkbox-container">
            <input type="checkbox" name="tags[]" value="Village"> Village
            <span class="checkmark"></span>
        </label>

        <label class="checkbox-container">
            <input type="checkbox" name="tags[]" value="Abandoned"> Abandoned
            <span class="checkmark"></span>
        </label>

        <label class="checkbox-container">
            <input type="checkbox" name="tags[]" value="Ruins"> Ruins
            <span class="checkmark"></span>
        </label>

        <label class="checkbox-container">
            <input type="checkbox" name="tags[]" value="Castle"> Castle
            <span class="checkmark"></span>
        </label>

        <label class="checkbox-container">
            <input type="checkbox" name="tags[]" value="Dungeon"> Dungeon
            <span class="checkmark"></span>
        </label>

        <label class="checkbox-container">
            <input type="checkbox" name="tags[]" value="Temple"> Temple
            <span class="checkmark"></span>
        </label>

        <label class="checkbox-container">
            <input type="checkbox" name="tags[]" value="Camp"> Camp
            <span class="checkmark"></span>
        </label>


        <label for="custom_tag">Custom Tag:</label>
        <input type="text" name="custom_tag" id="custom_tag"><br>

        <button type="submit" name="create_place">Create Place</button>
    </form>
