<?php
session_start();

/**
 * This is the beta testing file unlike index.php which gets the player name 
 * normally which is name='ToxicggPE' this is whatever is set in the loginsystem (name)
 */

include 'pconfig.php';

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: testerlogin.php");
    exit;
}

$username = $_SESSION['username'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

// check for query execution errors
if (!$result) {
     echo "Error executing query: " . mysqli_error($conn);
     exit();
}

while($row = mysqli_fetch_assoc($result)){
echo " - Name: " . $row["username"]. "<br>" ." - Kills: " . $row["kills"]. "<br>" . "- Wins:" . $row["wins"]. "<br>" . "- Deaths:" . $row["deaths"]. "<br>";
}
mysqli_close($conn);

?>


