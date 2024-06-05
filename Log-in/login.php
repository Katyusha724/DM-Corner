<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/../database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
           
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: ../index-log.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>

<?php include '../head.php'; ?>

<body class="background-1">
    <canvas id="canvas"></canvas>
    
    <?php include '../navigation-1.php'; ?>

    <section class="container-column blur-box">

        <h1>Login</h1>

        <div class="triple-diamond-deco-container">
            <div class="left-line"></div>
            <div class="right-line"></div>
            <div class="small-diamond-left"></div>
            <div class="small-diamond-right"></div>
            <div class="large-diamond"></div>
        </div>
        
        <?php if ($is_invalid): ?>
            <em>Invalid login</em>
        <?php endif; ?>
        
        <form method="post">
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
                value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
            
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            
            <button>Log in</button>
        </form>

       

    </section>
    

    <?php include '../footer.php'; ?>
    <script src="../JavaScript/fireflies.js"></script>
</body>
</html> 