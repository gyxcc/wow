<?php
require_once 'db_connect.php';

function get_post($conn, $var) {
    return $conn->real_escape_string($_POST[$var]);
}

if (isset($_POST['User_Name']) &&
    isset($_POST['Char_Name']) &&
    isset($_POST['Location']) &&
    isset($_POST['Head_name']) &&
    isset($_POST['Head_Contact_num']) &&
    isset($_POST['Head_identity_id']) &&
    isset($_POST['password'])) {

    // 假设已经有一个有效的数据库连接$conn
    $User_Name = get_post($conn, 'User_Name');

    // 检查User_Name是否已存在
    $query = "SELECT * FROM charity WHERE User_Name = '$User_Name'";
    $result = mysqli_query($conn, $query);

    // 如果$result有一行或多行数据，说明User_Name已存在
    if ($result && mysqli_num_rows($result) > 0) {
        echo "The username is already taken. Please choose another.";
    } else {
        // User_Name不存在，执行插入用户的代码
        $Char_Name = get_post($conn, 'Char_Name');
        $Location = get_post($conn, 'Location');
        $Head_name = get_post($conn, 'Head_name');
        $Head_Contact_num = get_post($conn, 'Head_Contact_num');
        $Head_identity_id = get_post($conn, 'Head_identity_id');
        $password = get_post($conn, 'password');
        $user_type = 'Charity';
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO login (User_Name,Password, User_type) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $User_Name, $hashedPassword, $user_type);
        if ($stmt->execute()) {
        } else {
            echo "INSERT failed: $query<br>" . $stmt->error . "<br><br>";
        }
        $stmt->close();
        
        $query_2 = "SELECT User_id FROM login WHERE User_Name = '$user_name '";
        $result = mysqli_query($conn, $query_2);
        $row = $result->fetch_array(MYSQLI_NUM);
        $User_id = $row[0];
        $query1 = "INSERT INTO charity (User_Name, Char_Name, Location, Head_name, Head_Contact_num, Head_identity_id, password, User_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query1);
        $stmt->bind_param("ssssssss", $User_Name, $Char_Name, $Location, $Head_name, $Head_Contact_num, $Head_identity_id, $hashedPassword, $user_type);
        if ($stmt->execute()) {
            echo "Record inserted successfully!<br><br>";
        } else {
            echo "INSERT failed: $query1<br>" . $stmt->error . "<br><br>";
        }
        $stmt->close();
    }
}

// 下面是表单HTML
echo <<<_END
<form action="C.php" method="post">
<pre>
user_type: Charity
User_Name <input type="text" name="User_Name">
Char_Name <input type="text" name="Char_Name">
Location <input type="text" name="Location">
Head_name <input type="text" name="Head_name">
Head_Contact_num <input type="text" name="Head_Contact_num">
Head_identity_id <input type="text" name="Head_identity_id"> 
password <input type="text" name="password">
<input type="submit" value="ADD RECORD">
</pre>
<form action="C.php" method="POST">
    <p>Already have an account? Click <input type="submit" value="Login"></p>
</form>
_END;
?>
