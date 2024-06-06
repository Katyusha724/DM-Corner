<nav>
    <div class="topnav" id="myTopnav1">
        <div class="topnav-container">
            <a href="index-log.php">Dungeon Master Corner</a>
            <a href="index-log.php">Campaings</a>
            <?php if (isset($user)): ?>
                <a><b><?= htmlspecialchars($user["username"]) ?></p></b></a>
                <a href="Log-in/logout.php">Log out</a>
            <?php else: ?>
                <p><a href="Log-in/login.php">Log in</a> or <a href="Sign-in/signup.html">sign up</a></p>
            <?php endif; ?>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </div>
</nav>



<script>
function myFunction() {
  var x = document.getElementById("myTopnav1");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
