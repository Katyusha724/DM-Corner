<nav>

    <div class="topnav" id="myTopnav2">
        <div class="topnav-container">
            <a href="../index.php">Dungeon Master Corner</a>
            <a href="../Log-in/login.php">Log In</a>
            <a href="../Sign-in/signup.php">Sign Up</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </div>
</nav>

<script>
function myFunction() {
  var x = document.getElementById("myTopnav2");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
