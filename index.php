<?php include('navbar.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login – Pick n Go</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="container">
        <div class="login-container">
            <img src="/frontend/public/picknGologo.png" alt="Pick n Go Logo" class="logo">
            <h2>Customer Login</h2>

            <!-- Login Form -->
            <form id="loginForm">
                <input type="hidden" name="action" value="login">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>

            <p>Don't have an account? <a href="#" id="showSignup">Sign up</a></p>
        </div>

        <!-- Signup Form (Hidden by Default) -->
        <div class="signup-container" style="display: none;">
            <h2>Sign Up</h2>
            <form id="signupForm">
                <input type="hidden" name="action" value="signup">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Sign Up</button>
            </form>

            <p>Already have an account? <a href="#" id="showLogin">Login</a></p>
        </div>
    </main>

    <script>
        // Toggle between login and signup forms
        document.getElementById('showSignup').addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelector('.login-container').style.display = 'none';
            document.querySelector('.signup-container').style.display = 'block';
        });

        document.getElementById('showLogin').addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelector('.signup-container').style.display = 'none';
            document.querySelector('.login-container').style.display = 'block';
        });

        // Handle form submissions
        document.getElementById('loginForm').addEventListener('submit', (e) => {
            e.preventDefault();
            fetch('auth.php', {
                method: 'POST',
                body: new FormData(e.target)
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.message === "Login successful") {
                    window.location.href = "dashboard.php"; // Redirect to dashboard
                }
            });
        });

        document.getElementById('signupForm').addEventListener('submit', (e) => {
            e.preventDefault();
            fetch('auth.php', {
                method: 'POST',
                body: new FormData(e.target)
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.message === "User registered successfully") {
                    window.location.href = "index.php"; // Redirect to login
                }
            });
        });
    </script>
</body>
</html>
