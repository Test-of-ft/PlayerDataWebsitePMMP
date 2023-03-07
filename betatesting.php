<?php
session_start();

/**
 * This is the beta testing file unlike index.php which gets the player name 
 * normally which is name='ToxicggPE' this is whatever is set in the loginsystem (name)
 */

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

$username = $_SESSION['username'];
$sql = "SELECT kills,wins,deaths FROM playerstatics WHERE name=$username";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Name: " . $row["name"]. " - Kills: " . $row["kills"]. "<br>";
    }
} else {
    echo "You do not have any data";
}

?>


