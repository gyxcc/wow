<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h2>Login Form</h2>
    <form method="POST" action="">

        <label>Username:</label>
        <input type="text" name="username" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        
        <input type='hidden' name='action' value='create' />
        <input type="submit" value="Log In">
    </form>
</body>
</html>
<?php
session_start();
if (isset($_POST['action'])) 
    $action = $_POST['action']; 
else
    $action = ""; 

if ($action == 'create') {
$un_temp = $_POST['username'];
$pw_temp = $_POST['password'];
$_SESSION["username"] = $un_temp;
require_once "db_connect.php";

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param('s', $un_temp);
$stmt->execute();
$result = $stmt->get_result(); 
if (!$result) {
        die("User not found");
    } elseif ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        if (password_verify($pw_temp, $row[3])) {
            $_SESSION["forename"] = $row[0];
            $_SESSION["surname"] = $row[1];
            echo htmlspecialchars("$row[0] $row[1] :
Hi $row[0], you are now logged in as '$row[2]'");
            die("<p><a href='continue.php'>Click here to continue</a></p>");
        } else {
            die("Invalid username/password combination");
        }
    } else {
        die("Invalid username/password combination");
    } 
}
?>
