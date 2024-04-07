<?php
require_once 'db_connect.php';

function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
}

if (isset($_POST['user_name']) &&
    isset($_POST['Store_name']) &&
    isset($_POST['Store_kind']) &&
    isset($_POST['Location']) &&
    isset($_POST['Head_name']) &&
    isset($_POST['Head_Contact_num']) &&
    isset($_POST['Head_Identity_num']) &&
    isset($_POST['password'])) {
    
    $user_name = get_post($conn, 'user_name');
    $Store_name = get_post($conn, 'Store_name');
    $Store_kind = get_post($conn, 'Store_kind');
    $Location = get_post($conn, 'Location');
    $Head_name = get_post($conn, 'Head_name');
    $Head_Contact_num = get_post($conn, 'Head_Contact_num');
    $Head_Identity_num = get_post($conn, 'Head_Identity_num');
    $password = get_post($conn, 'password');
    $user_type = 'Store';
    
    // 检查Store_name是否已存在
    $query = "SELECT * FROM volunteer WHERE user_name = '$user_name'";
    $result = mysqli_query($conn, $query);

    if ($result && $result->num_rows > 0) {
        echo "The store name is already taken. Please choose another.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $query = "INSERT INTO login (User_Name,Password, User_type) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $user_name, $hashedPassword, $user_type);
        if ($stmt->execute()) {
           
        } else {
            echo "INSERT failed: $query<br>" . $stmt->error . "<br><br>";
        }
        $stmt->close();
    }
        
        $query_1 = "SELECT User_id FROM login WHERE User_Name = '$user_name';";
        $result = mysqli_query($conn, $query_1);
        $row = $result->fetch_array(MYSQLI_NUM);
        $User_id = $row[0];
        $query = "INSERT INTO store (User_id, User_type, User_name, Store_name,Store_kind, Location, Head_name, Head_Contact_num, Head_Identity_num,  password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssssssss", $User_id, $user_type, $user_name, $Store_name, $Store_kind, $Location, $Head_name, $Head_Contact_num, $Head_Identity_num, $hashedPassword);
        if ($stmt->execute()) {
            echo "Record inserted successfully!<br><br>";
        } else {
            echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";
        }
        $stmt->close();
        

}

// 下面是表单HTML
echo <<<_END
<form action="S.php" method="post">
<pre>
User_type: Store
user_name <input type="text" name="user_name">
password <input type="text" name="password">
Store_name <input type="text" name="Store_name">
Store_kind <input type="text" name="Store_kind">
Location <input type="text" name="Location">
Head_name <input type="text" name="Head_name">
Head_Contact_num <input type="text" name="Head_Contact_num">
Head_Identity_num <input type="text" name="Head_Identity_num">
<input type="submit" value="ADD RECORD">
</pre>
<form action="register.php" method="POST">

    <p>Already have an account? Click  <input type="submit" value="Login"> </p>

</form>
_END;

?>
