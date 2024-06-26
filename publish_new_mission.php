<?php
// 启动会话
session_start();

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
    <form method="post" action="">
        <table>
            <thead>
                <tr>
                    <th>Food id</th>
                    <th>Food Type</th>
                    <th>Food Status</th>
                    <th>Expiration Date</th>
                    <th>Amount</th>
                    <th>choose</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM food;";
                $result_0 = $conn->query($query);
                while ($row = $result_0->fetch_assoc()):
                ?>
                    <tr>
                        <td><?php echo $row['Food_id'];?></td>
                        <td><?php echo $row['Food_type'];?></td>
                        <td><?php echo $row['Food_status'];?></td>
                        <td><?php echo $row['Expiration_date'];?></td>
                        <td><?php echo $row['Amount'];?></td>
                        <td><input type="checkbox" name="selectedFood[]" value="<?php echo $row['Food_id'];?>"></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <input type="submit" name="foodButton" value="choose food">
    </form>

    <h2>Available Medicine</h2>
    <form method="post" action="">
        <table>
            <thead>
                <tr>
                    <th>Medicine id</th>
                    <th>Medicine Type</th>
                    <th>Medicine Status</th>
                    <th>Expiration Date</th>
                    <th>Amount</th>
                    <th>choose</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM medicine;";
                $result_0 = $conn->query($query);
                while ($row = $result_0->fetch_assoc()):
                ?>
                    <tr>
                        <td><?php echo $row['Medicine_id'];?></td>
                        <td><?php echo $row['Medicine_type'];?></td>
                        <td><?php echo $row['Medicine_status'];?></td>
                        <td><?php echo $row['Expiration_date'];?></td>
                        <td><?php echo $row['Amount'];?></td>
                        <td><input type="checkbox" name="selectedMedicine[]" value="<?php echo $row['Medicine_id'];?>"></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <input type="submit" name="medicineButton" value="choose medicine">
    </form>


  <?php

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
      require_once 'db_connect';
    // 检查已选择的食物和药物
    if (isset($_SESSION['selectedFood'])) {
      $selectedFood = $_SESSION['selectedFood'];
      $Char_name = $_SESSION['Char_name'];
      $Distribution_time = $_POST['distribution_time'];
      $Gathering_point = $_POST['gathering_point'];
      $Charity_location = $_POST['charity_location'];
      $Mission_status = "not accepted";
      $stmt_0 = $conn->prepare("INSERT INTO mission_charity_to_point(Distribution_time, Gathering_point, Charity_location, Mission_status) VALUES(?,?,?,?)");
      $stmt_0->bind_param("ssss", $Distribution_time, $Gathering_point, $Charity_location, $Mission_status);
      $stmt->execute();
      $stmt_1 = $conn->prepare("SELECT Mission_id FROM mission_charity_to_point WHERE Gathering_point = ? AND Charity_location = ? AND Mission_status = ?");
      $stmt_1->bind_param('sss', $Gathering_point, $Charity_location,$Mission_status);
      $result =$stmt_1->execute();
      $row = $result->fetch_array(MYSQLI_NUM);  
      // 执行操作
      foreach ($selectedFood as $foodId) {
          //food
          $stmt_2 = $conn->prepare("UPDATE food SET Food_status = 'reserved', Mission_id = ?");
          $stmt_2->bind_param('i',$row[0]);
          $result_0 = $stmt_2->execute();
          echo $result_0;
      }
      
      unset($_SESSION['selectedFood']);
      
    }; 
    
    if (isset($_SESSION['selectedMedicine'])) {
        foreach($_SESSION['selectedMedicine'] as $medicineId) {
            //medicine
            $stmt_3 = $conn->prepare("UPDATE medicine SET Medicine_status = 'reserved', Mission_id = ?");
            $stmt_3->bind_param('i',$row[0]); 
            $result_1 = $stmt_3->execute(); 
            echo $result;
        }
        unset($_SESSION['selectedMedicine']);
    }                                                                                                                            
  }
  ?>
<!-- 显示当前选择的食物和药物 -->
<?php if (!empty($selectedItems)): ?>
    <h3>Selected Items:</h3>
    <ul>
        <?php 
        foreach ($_SESSION['selectedFood'] as $foodId) {
            echo "<li>Food ID: " . htmlspecialchars($foodId) . "</li>";
        }
        foreach ($_SESSION['selectedMedicine'] as $medicineId) {
            echo "<li>Medicine ID: " . htmlspecialchars($medicineId) . "</li>";
        }
        ?>
    </ul>
<?php endif; ?>
          <h2>Publish New Missions</h2>
    <form method="POST" action="">

        <label>DATE(YYYY-MM-DD)</label>
        <input type="text" name="Date" required><br><br>
        
        <label>START TIME(HH:MM:SS):</label>
        <input type="text" name="expiration_date" required><br><br>
        
        <label>Gathering Point</label>
        <input type="text" name="gathering_point" required><br><br>

        <label>Charity Location</label>
        <input type="text" name="charity_Location" required><br><br>
        
        <input type='hidden' name='action' value='create' />
        <input type="submit" value="Log In">
    </form>
    </body>
</html>
