<?php
// db.php
$host = 'your_host';
$port = 'your_port';
$dbname = 'your_dbname';
$user = 'your_username';
$password = 'your_password';

$conn = oci_connect($user, $password, "//$host:$port/$dbname");

if (!$conn) {
    $e = oci_error();
    die("Database connection failed: " . $e['message']);
}
?>
