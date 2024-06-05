<?php
header('Content-Type: application/json');
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];

    if (empty($username)) {
        $errors['username'] = 'Username is required';
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    if ($password !== $password_confirmation) {
        $errors['password_confirmation'] = 'Passwords do not match';
    }

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit();
    }

    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $mysqli = require __DIR__ . "/../database.php";

    $sql = "INSERT INTO user (username, email, password_hash)
            VALUES (?, ?, ?)";
            
    $stmt = $mysqli->stmt_init();

    if ( ! $stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("sss",
                    $_POST["username"],
                    $_POST["email"],
                    $password_hash);
                    
    if ($stmt->execute()) {

        header("Location: signup-success.php");
        exit;
        
    } else {
        
        if ($mysqli->errno === 1062) {
            die("Email already taken");
        } else {
            die($mysqli->error . " " . $mysqli->errno);
        }
    }

    echo json_encode(['success' => true]);
    exit();
}

echo json_encode(['success' => false, 'errors' => ['form' => 'Invalid form submission']]);




?>