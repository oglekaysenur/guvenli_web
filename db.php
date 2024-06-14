<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); // NOTICE ve WARNING hatalarını gizler
session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "security_demo";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
