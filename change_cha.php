<?php
session_start();
require_once "db_connect.php";

$user_id = $_SESSION["user_id"];
echo "Received id : $user_id";

$sql = "SELECT Char_Name, Location, Head_Name, Head_Contact_Num, Head_Id FROM charity WHERE User_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();  // 获取一行数据
    
    // 创建可编辑的输入框，将数据显示在输入框中
    echo '<form method="POST" action="">';
    echo 'Char_Name: <input type="text" name="Char_Name" value="' . $row['Char_Name'] . '">';
    echo 'Location: <input type="text" name="Location" value="' . $row['Location'] . '">';
    echo 'Head Name: <input type="text" name="Head_Name" value="' . $row['Head_Name'] . '">';
    echo 'Head_Contact_Num: <input type="text" name="Head_Contact_Num" value="' . $row['Head_Contact_Num'] . '">';
    echo 'Head_Id: <input type="text" name="Head_Id" value="' . $row['Head_Id'] . '">';
    
    echo '<input type="submit" name = "submit" value="提交">';
    echo '</form>';
    // 提交表单时更新数据库
    if (isset($_POST['submit'])) {
        // 获取输入框中的数据
        $input1Value = $_POST['Char_Name'];
        $input2Value = $_POST['Location'];
        $input3Value = $_POST['Head_Name'];
        $input4Value = $_POST['Head_Contact_Num'];
        $input5Value = $_POST['Head_Id'];

        $User_id = $_SESSION['user_id'];
        // 更新数据库
        $sql = "UPDATE charity SET Char_Name='$input1Value', Location='$input2Value', Head_Name='$input3Value', Head_Contact_Num='$input4Value', Head_Id='$input5Value' WHERE User_id = $user_id";
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
