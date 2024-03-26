<?php
require_once 'db_connect.php';

function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
}

if (isset($_POST['User_id']) &&
    isset($_POST['user_name']) &&
    isset($_POST['user_contact']) &&
    isset($_POST['identity'])) {

    $User_id = get_post($conn, 'User_id');
    $user_name = get_post($conn, 'user_name');
    $user_contact = get_post($conn, 'user_contact');
    $identity = get_post($conn, 'identity');

    $query = "INSERT INTO classics (User_id, user_name, user_contact, identity) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $User_id, $user_name, $user_contact, $identity);
    if ($stmt->execute()) {
        echo "Record inserted successfully!<br><br>";
    } else {
        echo "INSERT failed: $query<br>" . $stmt->error . "<br><br>";
    }
    $stmt->close();
}

echo <<<_END
<form action="sign_S.php" method="post">
<pre>
User_id <input type="text" name="User_id">
user_name <input type="text" name="user_name">
user_contact <input type="text" name="user_contact">
identity <input type="text" name="identity">
<input type="submit" value="ADD RECORD">
</pre>
</form>
<form action="login.php" method="get">
    <p>Already have an account? Click <input type="submit" value="Login"></p>
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
User_id: $row[0]
user_name: $row[1]
user_contact: $row[2]
identity: $row[3]
</pre>
<form action="sign_S.php" method="post">
<input type="
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
