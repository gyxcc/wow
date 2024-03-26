<?php
$servername = "localhost";
$username = "WY";
$password = "qi3yun2wang";
$dbname = "foodshare";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

