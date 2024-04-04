<?php
session_start();
require_once "db_connect.php";

$user_id = $_SESSION["user_id"];
echo "Received id : $user_id";

$sql = "SELECT Sto_name, Location, Head_name, Head_contact_num, Head_identity_num FROM store WHERE User_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();  // 获取一行数据
    
    // 创建可编辑的输入框，将数据显示在输入框中
    echo '<form method="POST" action="">';
    echo 'Store Name: <input type="text" name="Store_name" value="' . $row['Sto_name'] . '">';
    echo 'Location: <input type="text" name="Location" value="' . $row['Location'] . '">';
    echo 'Head Name: <input type="text" name="Head_name" value="' . $row['Head_name'] . '">';
    echo 'Head Contact Numebr: <input type="text" name="Head_contact_num" value="' . $row['Head_contact_num'] . '">';
    echo 'Head Identity Number: <input type="text" name="Head_identity_num" value="' . $row['Head_identity_num'] . '">';
    
    echo '<input type="submit" name = "submit" value="提交">';
    echo '</form>';
    // 提交表单时更新数据库
    if (isset($_POST['submit'])) {
        // 获取输入框中的数据
        $input1Value = $_POST['Store_name'];
        $input2Value = $_POST['Head_name'];
        $input3Value = $_POST['Head_contact_num'];
        $input4Value = $_POST['Head_identity_num'];
        $input5Value = $_POST['Location'];
        // ...
        $User_id = $_SESSION['user_id'];
        // 更新数据库
        $sql = "UPDATE store SET Sto_name='$input1Value', Head_name='$input2Value', Head_contact_num='$input3Value', Head_identity_num='$input4Value' WHERE User_id = $user_id";
        if ($conn->query($sql) === TRUE) {
            echo "数据更新成功";
        } else {
            echo "数据更新失败: " . $conn->error;
        }
    }
} else {
    echo "未找到匹配的数据";
}

// 关闭数据库连接
$conn->close();
?>
