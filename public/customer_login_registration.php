<?php
// Handle form submission (frontend only - no backend)
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
    <title>Customer Login & Signup</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <!-- Logo Section -->
        <div class="logo-container">
            <img src="assets/logo.png" alt="Customer Logo">
        </div>

        <h2 id="form-title">Customer Login</h2>

