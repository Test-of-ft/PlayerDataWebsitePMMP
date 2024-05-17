<?php

$servername = "panel.taitanmc.fun";
$username = "u19_WRoQJxaSjJ";
$password = "bfobTDn!5Imgz9=Bv=UDKjNs";
$dbname = "stats";

// Create connection #1
$conn = new mysqli($servername, $username, $password, $dbname);

// Check con
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
