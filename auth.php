<?php
// auth.php
session_start();
include('db.php');

header('Content-Type: application/json');

// Signup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'signup') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $customer_id = uniqid();

    $sql = "INSERT INTO users (customer_id, email, password_hash) VALUES (:customer_id, :email, :password_hash)";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':customer_id', $customer_id);
    oci_bind_by_name($stmt, ':email', $email);
    oci_bind_by_name($stmt, ':password_hash', $password);

    if (oci_execute($stmt)) {
        echo json_encode(["message" => "User registered successfully", "customer_id" => $customer_id]);
    } else {
        echo json_encode(["message" => "Registration failed"]);
    }
}

// Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':email', $email);
    oci_execute($stmt);
    $user = oci_fetch_assoc($stmt);

    if ($user && password_verify($password, $user['PASSWORD_HASH'])) {
        $_SESSION['user_id'] = $user['CUSTOMER_ID'];
        echo json_encode(["message" => "Login successful", "user_id" => $user['CUSTOMER_ID']]);
    } else {
        echo json_encode(["message" => "Invalid credentials"]);
    }
}

// Logout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
    session_destroy();
    echo json_encode(["message" => "Logged out successfully"]);
}

// Fetch Profile
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'profile') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["message" => "Unauthorized"]);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT email FROM users WHERE customer_id = :user_id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':user_id', $user_id);
    oci_execute($stmt);
    $user = oci_fetch_assoc($stmt);

    if ($user) {
        echo json_encode(["email" => $user['EMAIL'], "user_id" => $user_id]);
    } else {
        echo json_encode(["message" => "User not found"]);
    }
}
?>
