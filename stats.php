<?php
session_start();

/**
 * Stats.php
 * Gets stats of the player
 */

include 'config.php';
include 'microsoft-login.php';

$username = getGamerTag();
$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

// check for query execution errors
if (!$result) {
     echo "Error executing query: " . mysqli_error($conn);
     exit();
}

while($row = mysqli_fetch_assoc($result)){
$k = $row["kills"];
$d = $row["deaths"];
$ratio = $k / $d;
echo " - Name: " . $row["username"]. "<br>" ." - Kills: " . $row["kills"]. "<br>" . "- Wins:" . $row["wins"]. "<br>" . "- Deaths:" . $row["deaths"]. "<br>" .  "KDR: " . $ratio . "<br>";
}
mysqli_close($conn);

?>


