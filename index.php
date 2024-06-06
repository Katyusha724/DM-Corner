<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DM Corner</title>
        <link rel="stylesheet" href="Style/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body class="background-1">
    <canvas id="canvas"></canvas>
    <nav>
    <div class="topnav" id="myTopnav3">
        <div class="topnav-container">
            <a href="index.php">Dungeon Master Corner</a>
            <a href="Log-in/login.php">Log In</a>
            <a href="Sign-in/signup.php">Sign Up</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </div>

</nav>

        <header>
            <div>
                <h1>Dungeon Master Corner</h1>
                <br>
                <div class="triple-diamond-deco-container">
            <div class="left-line"></div>
            <div class="right-line"></div>
            <div class="small-diamond-left"></div>
            <div class="small-diamond-right"></div>
            <div class="large-diamond"></div>
        </div><br>
                <p>by Petra Kukić Halužan</p>
            </div>
        </header>


        <section>

        </section>

        <?php include 'footer.php'; ?>
        <script src="JavaScript/fireflies.js"></script>
        <script>
            function myFunction() {
            var x = document.getElementById("myTopnav3");
                if (x.className === "topnav") {
                    x.className += " responsive";
                } else {
                    x.className = "topnav";
                }
            }
        </script>
    </body>
</html>
