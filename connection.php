<?php
$host = "localhost";
$user = "root";
$pass = "K@one2001";
$db = "cet333";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Failed to connect to the database: " . $conn->connect_error);
}
?>
