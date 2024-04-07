<?php
require_once 'db_connect.php';

function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
}

if (isset($_POST['user_name']) &&
    isset($_POST['user_contact']) &&
    isset($_POST['identity']) &&
    isset($_POST['password'])) {
    
    $user_name = get_post($conn, 'user_name');
    $user_contact = get_post($conn, 'user_contact');
    $identity = get_post($conn, 'identity');
    $password = get_post($conn, 'password');
    $user_type = 'Volunteer';

    // 检查user_name是否已存在
    $query = "SELECT * FROM volunteer WHERE user_name = '$user_name'";
    $result = mysqli_query($conn, $query);

    // 如果$result有一行或多行数据，说明user_name已存在
    if ($result && mysqli_num_rows($result) > 0) {
        echo "The username is already taken. Please choose another.";
    } else {
        // 如果user_name不存在，则执行插入操作
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $query1 = "INSERT INTO login (User_Name,Password, User_type) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query1);
        $stmt->bind_param("sss", $user_name, $hashedPassword, $user_type);
        if ($stmt->execute()) {
        } else {
            echo "INSERT failed: $query1<br>" . $stmt->error . "<br><br>";
        }
        $stmt->close();
       
        $query_2 = "SELECT User_id FROM login WHERE User_Name = '$user_name '";
        $result = mysqli_query($conn, $query_2);
        $row = $result->fetch_array(MYSQLI_NUM);
        $User_id = $row[0];
        $query = "INSERT INTO volunteer (user_name, user_contact_num, identity, password, user_type) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $user_name, $user_contact, $identity, $hashedPassword, $user_type);
        if ($stmt->execute()) {
            echo "Record inserted successfully!<br><br>";
        } else {
            echo "INSERT failed: $query<br>" . $stmt->error . "<br><br>";
        }
        $stmt->close();
        
        
    }
}

// 这里是HTML表单的代码
echo <<<_END
<form action="V.php" method="post">

<pre>
user_type: Volunteer 
user_name <input type="text" name="user_name">
password <input type="text" name="password">
user_contact <input type="text" name="user_contact">
identity <input type="text" name="identity">
<input type="submit" value="ADD RECORD">
</pre>
<form action="login.php" method="get">
    <p>Already have an account? Click <input type="submit" value="Login"></p>
</form>
_END;

?>
