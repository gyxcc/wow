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

$stmt = $conn->prepare("SELECT * FROM login_info WHERE username = ?");
$stmt->bind_param('s', $un_temp);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
        die("User not found");
    } elseif ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        if ($pw_temp = $row[2]) {
            $_SESSION["user_id"] = $row[0];
            $_SESSION["username"] = $row[1];
            $stmt_1 = "SELECT Sto_name from store where User_id = $row[0];";
            $result_0 = $conn->query($stmt_1);
            $row_0 = $result_0->fetch_array(MYSQLI_NUM);
            $result_0->close();
            $_SESSION["sto_name"] = $row_0[0];//命名全局变量，可以在多个php中调用
            echo htmlspecialchars("$row_0[0] :
Hi $row_0[0], you are now logged in as '$row[1]'");
            die("<p><a href='dashboard_sto.php'>Click here to open the user dashboard</a></p>");
        } else {
            die("Invalid username/password combination");
        }
    } else {
        die("Invalid username/password combination");
    } 
}

?>
/*
$un_temp: 用户输入的用户名（见开头HTML）
$pw_temp: 用户输入的密码



*/
