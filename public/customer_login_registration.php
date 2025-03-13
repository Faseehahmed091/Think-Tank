<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login & Signup</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <!-- Logo Section -->
        <div class="logo-container">
            <img src="assets/logo.jpeg" alt="Customer Logo">
        </div>

        <h2 id="form-title">Customer Login</h2>

        <!-- Login Form -->
        <form id="login-form" autocomplete="off">
            <input type="email" name="customer_email" placeholder="Enter Email" required autocomplete="off">
            <input type="password" name="customer_password" placeholder="Enter Password" required autocomplete="new-password">
            <button type="submit">Login</button>
        </form>

        <!-- Signup Form -->
        <form id="signup-form" style="display: none;" autocomplete="off">
            <input type="text" name="fullname" placeholder="Full Name" required autocomplete="off">
            <input type="email" name="customer_email" placeholder="Enter Email" required autocomplete="off">
            <input type="password" name="customer_password" placeholder="Enter Password" required autocomplete="new-password">
            <button type="submit">Signup</button>
        </form>

        <!-- Toggle Button -->
        <button id="toggle-btn">Switch to Signup</button>

        <!-- Message Box -->
        <p id="message" style="color: red;"></p>
    </div>

    <script>
        const toggleBtn = document.getElementById("toggle-btn");
        const loginForm = document.getElementById("login-form");
        const signupForm = document.getElementById("signup-form");
        const formTitle = document.getElementById("form-title");
        const messageBox = document.getElementById("message");

        toggleBtn.addEventListener("click", function() {
            if (loginForm.style.display === "none") {
                loginForm.style.display = "block";
                signupForm.style.display = "none";
                formTitle.innerText = "Customer Login";
                toggleBtn.innerText = "Switch to Signup";
                messageBox.innerText = ""; 
            } else {
                loginForm.style.display = "none";
                signupForm.style.display = "block";
                formTitle.innerText = "Customer Signup";
                toggleBtn.innerText = "Switch to Login";
                messageBox.innerText = ""; 
            }
        });
    </script>
</body>
</html>




