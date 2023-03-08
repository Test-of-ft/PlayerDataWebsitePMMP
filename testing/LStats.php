<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: testerlogin.php");
    exit;
}

include 'pconfig.php';
 
// selects kills,wins,deaths from the table playerstatics in the database and selects name to = as ToxicggPE
// you can change this by making a login system which a person must enter there playername and you can get there name using $_SESSION['name'], in the login
// system its makes this a value what the player sets in the type.
// go to beta.php to see the best testing
$result = mysqli_query($conn, "SELECT * FROM users WHERE username='ToxicggPE'");
while($row = mysqli_fetch_assoc($result)){
echo " - Name: " . $row["username"]. " - Kills: " . $row["kills"], "<br>";
}
mysqli_close($conn);


?>


