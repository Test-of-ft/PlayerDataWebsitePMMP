<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: testerlogin.php");
    exit;
}

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

// selects kills,wins,deaths from the table playerstatics in the database and selects name to = as ToxicggPE
// you can change this by making a login system which a person must enter there playername and you can get there name using $_SESSION['name'], in the login
// system its makes this a value what the player sets in the type.
// go to beta.php to see the best testing
$sql = "SELECT kills,wins,deaths FROM playerstatics WHERE name='ToxicggPE'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Name: " . $row["name"]. " - Kills: " . $row["kills"]. "<br>";
    }
} else {
    echo "N/A";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
</body>
</html>


