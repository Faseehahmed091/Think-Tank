<?php
// Handle form submission (you will need a backend PHP script for authentication)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    echo "Processing login/signup for: " . htmlspecialchars($email);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trader Login & Signup</title>
    <link rel="stylesheet" href="assets/styles.css"> <!-- Updated path -->
</head>
<body>
    <div class="container">
        <!-- Logo Section -->
        <div class="logo-container">
            <img src="assets/logo.png" alt="Trader Logo">
        </div>

        <h2 id="form-title">Trader Login</h2>
        <form id="auth-form" method="POST" action="customer_login_and_register.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" id="confirm-password" name="confirmPassword" placeholder="Confirm Password" style="display: none;">
            <button type="submit">Login</button>
        </form>
        <button id="toggle-btn">Don't have an account? Signup</button>
    </div>

    <script>
        const toggleBtn = document.getElementById("toggle-btn");
        const formTitle = document.getElementById("form-title");
        const confirmPasswordInput = document.getElementById("confirm-password");

        let isLogin = true;

        toggleBtn.addEventListener("click", () => {
            isLogin = !isLogin;
            formTitle.innerText = isLogin ? "Trader Login" : "Trader Signup";
            confirmPasswordInput.style.display = isLogin ? "none" : "block";
            toggleBtn.innerText = isLogin ? "Don't have an account? Signup" : "Already have an account? Login";
        });
    </script
