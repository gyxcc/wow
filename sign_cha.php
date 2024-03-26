<?php
require_once 'db_connect.php';

function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
}

if (isset($_POST['User_id']) &&
    isset($_POST['Char_Name']) &&
    isset($_POST['Location']) &&
    isset($_POST['Head_name']) &&
    isset($_POST['Head_Contact_num'])) {

    $User_id = get_post($conn, 'User_id');
    $Char_Name = get_post($conn, 'Char_Name');
    $Location = get_post($conn, 'Location');
    $Head_name = get_post($conn, 'Head_name');
    $Head_Contact_num = get_post($conn, 'Head_Contact_num');
    $Head_identity_id = get_post($conn, 'Head_identity_id'); // Assuming you're receiving this from the form now.

    $query = "INSERT INTO classics (User_id, Char_Name, Location, Head_name, Head_Contact_num, Head_identity_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $User_id, $Char_Name, $Location, $Head_name, $Head_Contact_num, $Head_identity_id);
    if ($stmt->execute()) {
        echo "Record inserted successfully!<br><br>";
    } else {
        echo "INSERT failed: $query<br>" . $stmt->error . "<br><br>";
    }
    $stmt->close();
}

// 下面是表单HTML
echo <<<_END
<form action="sign_S.php" method="post">
<pre>
User_id <input type="text" name="User_id">
Char_Name <input type="text" name="Char_Name">
Location <input type="text" name="Location">
Head_name <input type="text" name="Head_name">
Head_Contact_num <input type="text" name="Head_Contact_num">
Head_identity_id <input type="text" name="Head_identity_id"> <!-- New field added -->
<input type="submit" value="ADD RECORD">
</pre>
</form>
<form action="register.php" method="POST">
    <p>Already have an account? Click <input type="submit" value="Login"></p>
</form>
_END;

// 下面是获取并显示数据库中记录的逻辑
$query = "SELECT * FROM classics";
$result = $conn->query($query);

if (!$result) {
    die("Database access failed: " . $conn->error);
}

$rows = $result->num_rows;


$result->close();
$conn->close();
?>
