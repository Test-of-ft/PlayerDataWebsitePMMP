<?php
$servername = "localhost";
$username = "stats";
$password = "";
$dbname = "stats";
// Create connection #1
$link = new mysqli($servername, $username, $password, $dbname);

// Check connection #2
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
?>