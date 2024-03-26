<?php
// sqltest.php
require_once 'db_connect.php';

if (isset($_POST['delete']) && isset($_POST['isbn'])) {
    $isbn = get_post($conn, 'isbn');
    $query = "DELETE FROM classics WHERE isbn='$isbn'";
    $result = $conn->query($query);
    if (!$result) {
        echo "DELETE failed: $query<br>" . $conn->error . "<br><br>";
    }
}

if (isset($_POST['Store_name']) &&
    isset($_POST['Store_kind']) &&
    isset($_POST['Location']) &&
    isset($_POST['Head_name']) &&
    isset($_POST['Head_Contact_number'])) {

    $Store_name = get_post($conn, 'Store_name');
    $Store_kind = get_post($conn, 'Store_kind');
    $Location = get_post($conn, 'Location');
    $Head_name = get_post($conn, 'Head_name');
    $Head_Contact_number = get_post($conn, 'Head_Contact_number');

    $query = "INSERT INTO classics (Store_name,Store_kind, Location, Head_name, Head_Contact_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $Store_name, $Store_kind, $Location, $Head_name, $Head_Contact_number);
    if ($stmt->execute()) {
        echo "Record inserted successfully!<br><br>";
    } else {
        echo "INSERT failed: $query<br>" . $stmt->error . "<br><br>";
    }
    $stmt->close();
}


// 修改表单字段名称以匹配 PHP 代码中的键
echo <<<_END

    <pre>
    Store_name <input type="text" name="Store_name">
    Store_kind <input type="text" name="Store_kind">
    Location <input type="text" name="Location">
    Head_name <input type="text" name="Head_name">
    Head_Contact_number <input type="text" name="Head_Contact_number">
    <input type="submit" value="ADD RECORD">
    </pre>
</form>
_END;


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
    Head_Contact_number: $row[4]
    </pre>
    <form action="sqltest.php" method="post">
        <input type="hidden" name="delete" value="yes">
        <input type="hidden" name="isbn" value="$row[4]">
        <input type="submit" value="DELETE RECORD">
    </form>
_END;
}

$result->close();
$conn->close();

function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
}
?>
