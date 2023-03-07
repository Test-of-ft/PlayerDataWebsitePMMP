<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection #1
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection #2
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>