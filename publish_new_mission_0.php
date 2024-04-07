<?php
// 启动会话
session_start();
$_SESSION['Char_Name']= $_POST['Char_Name'];
$_SESSION['Char_location'] = $_POST['Location'];
// 初始化或清空选中项
if (!isset($_POST['foodButton']) && !isset($_POST['medicineButton'])) {
    $_SESSION['selectedFood'] = [];
    $_SESSION['selectedMedicine'] = [];
}
// 数据库连接（请根据实际情况替换 'db_connect.php'）
require_once 'db_connect.php';

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['foodButton'])) {
        $_SESSION['selectedFood'] = isset($_POST['selectedFood']) ? $_POST['selectedFood'] : [];
    } elseif (isset($_POST['medicineButton'])) {
        $_SESSION['selectedMedicine'] = isset($_POST['selectedMedicine']) ? $_POST['selectedMedicine'] : [];
    }
}
$selectedItems = array_merge($_SESSION['selectedFood'], $_SESSION['selectedMedicine']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Publish New Missions</title>
</head>
<body>

    
    <h2>Available food</h2>
    <form method = 'post' action="">
  <table>
      <thead>
          <tr>
              <th>Food id</th>
              <th>Food Type</th>
              <th>Food Status</th>
              <th>Expiration Date</th>
              <th>Amount</th>
              <th>choose</th>
      </thead>
      <tbody>
          <?php //可用的食物
          require_once 'db_connect.php';
          $query = "SELECT * FROM food WHERE Food_status = 'new';";
          $result_0 = $conn->query($query);
          while ($row = $result_0->fetch_assoc()):?>
            <tr>
                <td><?php echo $row['Food_id'];?></td>
                <td><?php echo $row['Food_type'];?></td>
                <td><?php echo $row['Food_status'];?></td>
                <td><?php echo $row['Expiration_date'];?></td>
                <td><?php echo $row['Amount'];?></td><!-- comment -->
                <td><input type="checkbox" name="selectedData[]" value=<?php echo $row['Food_id']?>]></td>
            </tr>
        <?php endwhile; ?>
      </tbody>
  </table>
        <input type="submit" name="foodButton" value="choose food">
        </form>
      <h2>Available Medicine</h2>
      <form method = 'post' action="">
  <table>
      <thead>
          <tr>
              <th>Medicine id</th>
              <th>Medicine Type</th>
              <th>Medicine Status</th>
              <th>Expiration Date</th>
              <th>Amount</th>
              <th>choose</th>
      </thead>
      <tbody>
          <?php
          require_once 'db_connect.php';
          $query = "SELECT Medicine_id, Medicine_type, Medicine_status, Expiration_date, Amount FROM medicine WEHRE Medicine_status = 'new';";
          $result_0 = $conn->query($query);
          while ($row = $result_0->fetch_assoc()):?>
            <tr>
                <td><?php echo $row['Medicine_id'];?></td>
                <td><?php echo $row['Medicine_type'];?></td>
                <td><?php echo $row['Medicine_status'];?></td>
                <td><?php echo $row['Expiration_date'];?></td>
                <td><?php echo $row['Amount'];?></td><!-- comment -->
                <td><input type="checkbox"name="selectedData[]" value=<?php echo $row['Medicine_id']?>></td>
            </tr>
        <?php endwhile; ?>
      </tbody>
  </table>
      <input type="submit" name="medicineButton" value="choose medicine">
      </form>
  <form action="" method="post">
    <input type="submit" name="actionButton" value="submit">
  </form>
 <?php
  session_start();

  // 检查食物按钮的点击
  if (isset($_POST['foodButton'])) {
    if (!empty($_POST['selectedFood'])) {
      $_SESSION['selectedFood'] = $_POST['selectedFood'];
      
    }
  }

  // 检查药物按钮的点击
  if (isset($_POST['medicineButton'])) {
    if (!empty($_POST['selectedMedicine'])) {
      $_SESSION['selectedMedicine'] = $_POST['selectedMedicine'];
    }
  }

  // 检查操作按钮的点击
  if (isset($_POST['actionButton'])) {
      require_once 'db_connect.php';
    // 检查已选择的食物和药物
    if (isset($_SESSION['selectedFood'])) {
      $selectedFood = $_SESSION['selectedFood'];
      $Char_location = $_SESSION['Char_location'];
      $Date = $_POST['Date'];
      $Store_available_start_time = $_POST['Start_time'];
      $Store_available_end_time = $_POST['end_time'];
      $Mission_status = "not accepted";
      $stmt_0 = $conn->prepare("INSERT INTO mission_store_to_cha(Date, Store_available_start_time, Store_available_end_time, Mission_status, Char_location) VALUES(?,?,?,?)");
      $stmt_0->bind_param("sssss", $Date, $Store_available_start_time, $Store_available_end_time, $Mission_status, $Char_location);
      $stmt->execute();
      $stmt_1 = $conn->prepare("SELECT Mission_id FROM mission_store_to_cha WHERE Date = ? AND Char_location = ? AND Mission_status = ?");
      $stmt_1->bind_param('sss', $Date, $Char_location,$Mission_status);
      $result =$stmt_1->execute();
      $row = $result->fetch_array(MYSQLI_NUM);  
      // 执行操作
      foreach ($selectedFood as $foodId) {
          //food
          $stmt_2 = $conn->prepare("UPDATE food SET Food_status = 'available', Mission_id = ?");
          $stmt_2->bind_param('i',$row[0]);
          $result_0 = $stmt_2->execute();
          echo $result;
      }
      
      unset($_SESSION['selectedFood']);
      
    }; 
    
    if (isset($_SESSION['selectedMedicine'])) {
        foreach($_SESSION['selectedMedicine'] as $medicineId) {
            //medicine
            $stmt_3 = $conn->prepare("UPDATE medicine SET Medicine_status = 'available', Mission_id = ?");
            $stmt_3->bind_param('i',$row[0]); 
            $result_1 = $stmt_3->execute(); 
            echo $result;
        }
        unset($_SESSION['selectedMedicine']);
    }                                                                                                                            
  }
  ?>
          <h2>Publish New Missions</h2>
    <form method="POST" action="">

        <label>DATE(YYYY-MM-DD):</label>
        <input type="text" name="Date" required><br><br>
        
        <label>START TIME(HH:MM:SS):</label>
        <input type="text" name="start_time" required><br><br>
        
        <label>End TIME(HH:MM:SS):</label>
        <input type="text" name="end_time" required><br><br>

        <input type='hidden' name='action' value='create' />
        <input type="submit" value="Submit">
    </form>
</body>
</html>
