<?php include '../head.php'; ?>

<body class="background-1">
    <canvas id="canvas"></canvas>
    
    <?php include '../navigation-1.php'; ?>
    
    <section class="container-column blur-box">
        <h1>Sign Up</h1>

        <div class="triple-diamond-deco-container">
            <div class="left-line"></div>
            <div class="right-line"></div>
            <div class="small-diamond-left"></div>
            <div class="small-diamond-right"></div>
            <div class="large-diamond"></div>
        </div>

        <form id="signupForm" action="process-signup.php" method="post" novalidate>

            <div>
                <label for="username">Username: </label>
                <input type="text" id="username" name="username">
                <div id="usernameError" class="error-message"></div>  
            </div>

            <div>
                <label for="email">Email: </label>
                <input type="text" id="email" name="email">  
                <div id="emailError" class="error-message"></div>
            </div>

            <div>
                <label for="password">Password: </label>
                <input type="password" id="password" name="password">  
                <div id="passwordError" class="error-message"></div>
            </div>

            <div>
                <label for="password_confirmation">Confirm password: </label>
                <input type="password" id="password_confirmation" name="password_confirmation">  
                <div id="passwordConfirmationError" class="error-message"></div>
            </div>

            <button type="submit">Sign Up</button>
        </form>

    </section>
    <?php include '../footer.php'; ?>
    <script src="../JavaScript/fireflies.js"></script>
    <script>
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear previous error messages
            document.getElementById('usernameError').textContent = '';
            document.getElementById('emailError').textContent = '';
            document.getElementById('passwordError').textContent = '';
            document.getElementById('passwordConfirmationError').textContent = '';

            const formData = new FormData(this);
            
            fetch('process-signup.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect to signup-success.php
                    window.location.href = 'signup-success.php';
                } else {
                    // Display error messages
                    if (data.errors.username) {
                        document.getElementById('usernameError').textContent = data.errors.username;
                    }
                    if (data.errors.email) {
                        document.getElementById('emailError').textContent = data.errors.email;
                    }
                    if (data.errors.password) {
                        document.getElementById('passwordError').textContent = data.errors.password;
                    }
                    if (data.errors.password_confirmation) {
                        document.getElementById('passwordConfirmationError').textContent = data.errors.password_confirmation;
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>