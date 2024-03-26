<?php
require_once 'db_connect.php';

function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
}

if (isset($_POST['Store_name']) &&
    isset($_POST['Store_kind']) &&
    isset($_POST['Location']) &&
    isset($_POST['Head_name']) &&
    isset($_POST['Head_Contact_num'])) {

    $Store_name = get_post($conn, 'Store_name');
    $Store_kind = get_post($conn, 'Store_kind');
    $Location = get_post($conn, 'Location');
    $Head_name = get_post($conn, 'Head_name');
    $Head_Contact_num = get_post($conn, 'Head_Contact_num');

    $query = "INSERT INTO classics (Store_name,Store_kind, Location, Head_name, Head_Contact_num) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $Store_name, $Store_kind, $Location, $Head_name, $Head_Contact_num);
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
Store_name <input type="text" name="Store_name">
Store_kind <input type="text" name="Store_kind">
Location <input type="text" name="Location">
Head_name <input type="text" name="Head_name">
Head_Contact_num <input type="text" name="Head_Contact_num">
<input type="submit" value="ADD RECORD">
</pre>
<form action="register.php" method="POST">

    <p>Already have an account? Click  <input type="submit" value="Login"> </p>

</form>
_END;

// 下面是获取并显示数据库中记录的逻辑
$query = "SELECT * FROM classics";
$result = $conn->query($query);

if (!$result) {
    die("Database access failed: " . $conn->error);
}

$rows = $result->num_rows;

for ($j = 0; $j < $rows; ++$j) {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
<pre>
Store_name: $row[0]
Store_kind: $row[1]
Location: $row[2]
Head_name: $row[3]
Head_Contact_num: $row[4]
</pre>
<form action="sign_S.php" method="post">
<input type="hidden" name="delete" value="yes">
<input type="hidden" name="isbn" value="$row[4]">
</form>
_END;
}

$result->close();
$conn->close();
?>
