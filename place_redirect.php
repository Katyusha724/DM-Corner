<?php
ob_start();
require 'database.php';

$redirectUrl = null;

$mysqli = require __DIR__ . "/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_building'])) {
        $place_id = $_SESSION['place_id'];
        $building_name = $mysqli->real_escape_string($_POST['building_name']);

        $sql = "INSERT INTO buildings (place_id, building_name) VALUES (?, ?)";
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }
        $stmt->bind_param('is', $place_id, $building_name);
        $stmt->execute(); 

        $stmt->close();
        $redirectUrl = "place_dashboard.php?place_id=$place_id";

    } elseif (isset($_POST['save_npc_changes'])) {

        $building_id = $_SESSION['building_id'];
        $npc_name = $mysqli->real_escape_string($_POST['npc_name']);
        $npc_class = $mysqli->real_escape_string($_POST['npc_class']);
        $npc_race = $mysqli->real_escape_string($_POST['npc_race']);

        $Strenght = $mysqli->real_escape_string($_POST['Strenght']);
        $Dexterity = $mysqli->real_escape_string($_POST['Dexterity']);
        $Constitution = $mysqli->real_escape_string($_POST['Constitution']);
        $Intelligence = $mysqli->real_escape_string($_POST['Intelligence']);
        $Wisdom = $mysqli->real_escape_string($_POST['Wisdom']);
        $Charisma = $mysqli->real_escape_string($_POST['Charisma']);

        $npc_abilities = $mysqli->real_escape_string($_POST['npc_abilities']);
        $npc_description = $mysqli->real_escape_string($_POST['npc_description']);

        // Check if notes already exist
        $sql = "SELECT * FROM npcs WHERE building_id = ? AND user_id = ?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }
        $stmt->bind_param('ii', $building_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $npc_notes = $result->fetch_assoc();
        $stmt->close();

        if ($npc_notes) {
            // Update existing notes
            $sql = "UPDATE npcs SET npc_name = ?, npc_class = ?, npc_race = ?, Strenght = ?, Dexterity = ?, Constitution = ?, Intelligence = ?, Wisdom = ?, Charisma = ?, npc_abilities = ?, npc_description = ? WHERE building_id = ? AND user_id = ?";
            $stmt = $mysqli->prepare($sql);
            if ($stmt === false) {
                die("Prepare failed: " . $mysqli->error);
            }
            $stmt->bind_param('sssiiiiiissii', $npc_name, $npc_class, $npc_race, $Strenght, $Dexterity, $Constitution, $Intelligence, $Wisdom, $Charisma, $npc_abilities, $npc_description, $building_id, $user_id);
        } else {
            // Insert new notes
            $sql = "INSERT INTO npcs (npc_name, npc_class, npc_race, Strenght, Dexterity, Constitution, Intelligence, Wisdom, Charisma, npc_abilities, npc_description, building_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            if ($stmt === false) {
                die("Prepare failed: " . $mysqli->error);
            }
            $stmt->bind_param('sssiiiiiissii', $npc_name, $npc_class, $npc_race, $Strenght, $Dexterity, $Constitution, $Intelligence, $Wisdom, $Charisma, $npc_abilities, $npc_description, $building_id, $user_id);
        }

        $stmt->execute(); 
        $stmt->close();

        $redirectUrl = "place_dashboard.php?place_id=$place_id&building_id=$building_id";

        

    } elseif (isset($_POST['save_changes'])) {

        $basic_info = $mysqli->real_escape_string($_POST['basic_info']);
        $description = $mysqli->real_escape_string($_POST['description']);
        $dm_notes = $mysqli->real_escape_string($_POST['dm_notes']);
        $points_of_interest = $mysqli->real_escape_string($_POST['points_of_interest']);

        // Check if notes already exist
        $sql = "SELECT * FROM place_notes WHERE place_id = ? AND user_id = ?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }
        $stmt->bind_param('ii', $place_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $existing_notes = $result->fetch_assoc();
        $stmt->close();

        if ($existing_notes) {
            // Update existing notes
            $sql = "UPDATE place_notes SET basic_info = ?, description = ?, dm_notes = ?, points_of_interest = ? WHERE place_id = ? AND user_id = ?";
            $stmt = $mysqli->prepare($sql);
            if ($stmt === false) {
                die("Prepare failed: " . $mysqli->error);
            }
            $stmt->bind_param('ssssii', $basic_info, $description, $dm_notes, $points_of_interest, $place_id, $user_id);
        } else {
            // Insert new notes
            $sql = "INSERT INTO place_notes (place_id, user_id, basic_info, description, dm_notes, points_of_interest) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            if ($stmt === false) {
                die("Prepare failed: " . $mysqli->error);
            }
            $stmt->bind_param('iissss', $place_id, $user_id, $basic_info, $description, $dm_notes, $points_of_interest);
        }

        $stmt->execute();
        $stmt->close();
        $redirectUrl = "place_dashboard.php?place_id=$place_id";

    }  elseif (isset($_POST['building_id']) && isset($_POST['place_id'])) {
        $building_id = $_POST['building_id'];
        $place_id = $_POST['place_id'];

        $mysqli = require __DIR__ . "/database.php";

        $sql = "DELETE FROM buildings WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }
        $stmt->bind_param('i', $building_id);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();

        $redirectUrl = "place_dashboard.php?place_id=$place_id";
       

    } elseif (isset($_POST['edit_building'])) {
        // Code for editing a building

        $building_id = $_POST['building_id'];
        $building_name = $mysqli->real_escape_string($_POST['edit_building_name']);

        $sql = "UPDATE buildings SET building_name = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('si', $building_name, $building_id);
        $stmt->execute();
        $stmt->close();
        $redirectUrl = "place_dashboard.php?place_id=$place_id";
    
    } elseif (isset($_POST['edit_place'])) {
        // Code for editing a place
        $place_id = $_POST['place_id'];
        $place_name = $_POST['edit_place_name'];
        $place_tags = $_POST['edit_place_tags'];

        $sql = "UPDATE places SET place_name = ?, tags = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ssi', $place_name, $place_tags, $place_id);
        $stmt->execute();
        $stmt->close();

        $redirectUrl = "places.php?region_id=$region_id";

    } elseif (isset($_POST['delete_place'])) {
        // Code for deleting a place
        $place_id = $_POST['place_id'];

        $sql = "DELETE FROM places WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $place_id);
        $stmt->execute();
        $stmt->close();

        $redirectUrl = "places.php?region_id=$region_id";
    } elseif (isset($_POST['create_place'])) {
        // Code for creating a new place
        $region_id = $_SESSION['region_id'];
        $place_name = $mysqli->real_escape_string($_POST['place_name']);
        $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
        $custom_tag = !empty($_POST['custom_tag']) ? $mysqli->real_escape_string($_POST['custom_tag']) : '';

        // Combine predefined and custom tags
        if (!empty($custom_tag)) {
            $tags[] = $custom_tag;
        }
        $tags_str = implode(', ', $tags);

        $sql = "INSERT INTO places (region_id, user_id, place_name, tags) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }
        $stmt->bind_param('iiss', $region_id, $user_id, $place_name, $tags_str);

        if ($stmt->execute()) {
            $place_id = $stmt->insert_id; // Get the ID of the newly created place
            $redirectUrl = "place_dashboard.php?place_id=$place_id";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['save_quest_changes'])) {
        
        $building_id = $_SESSION['building_id'];
        $quest_name = $mysqli->real_escape_string($_POST['quest_name']);
        $goal = $mysqli->real_escape_string($_POST['goal']);
        $npc = $mysqli->real_escape_string($_POST['npc']);
        $place = $mysqli->real_escape_string($_POST['place']);
        $description = $mysqli->real_escape_string($_POST['description']);
        $reward_name = $mysqli->real_escape_string($_POST['reward_name']);
        $reward_description = $mysqli->real_escape_string($_POST['reward_description']);
        $reward_price = $mysqli->real_escape_string($_POST['reward_price']);
    
        // Check if quest already exists
        $sql = "SELECT * FROM quests WHERE building_id = ? AND user_id = ?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }
        $stmt->bind_param('ii', $building_id, $user_id)
        $stmt->execute();
        $result = $stmt->get_result();
        $quest_notes = $result->fetch_assoc();
        $stmt->close();
    
        if ($quest_notes) {
            // Update existing quest
            $sql = "UPDATE quests SET quest_name = ?, goal = ?, npc = ?, place = ?, description = ?, reward_name = ?, reward_description = ?, reward_price = ? WHERE building_id = ? AND user_id = ?";
            $stmt = $mysqli->prepare($sql);
            if ($stmt === false) {
                die("Prepare failed: " . $mysqli->error);
            }
            $stmt->bind_param('ssssssssii', $quest_name, $goal, $npc, $place, $description, $reward_name, $reward_description, $reward_price, $building_id, $user_id);
        } else {
            // Insert new quest
            $sql = "INSERT INTO quests (quest_name, goal, npc, place, description, reward_name, reward_description, reward_price, building_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            if ($stmt === false) {
                die("Prepare failed: " . $mysqli->error);
            }
            $stmt->bind_param('ssssssssii', $quest_name, $goal, $npc, $place, $description, $reward_name, $reward_description, $reward_price, $building_id, $user_id);
        }
    
        $stmt->execute();
        $stmt->close();
    
        $redirectUrl = "place_dashboard.php?place_id=$place_id&building_id=$building_id";
    }

    // Close the database connection if it is open

    if ($redirectUrl) {
        header("Location: $redirectUrl");
        exit();
    }

}

ob_end_flush();
?>
