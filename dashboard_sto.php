<!DOCTYPE html>
<html>
<head>
<style>
.container {
  width: 100%;
  margin: 20px auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

th, td {
  padding: 8px;
  border: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
}

tr:nth-child(even) {
  background-color: #f9f9f9;
}

tr:hover {
  background-color: #f5f5f5;
}

.button {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 8px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  margin: 4px 2px;
  cursor: pointer;
}

.add-button {
  background-color: #008CBA;
}

.add-button:hover {
  background-color: #0073a9;
}
</style>
<h1>欢迎回来，123!</h1>
</head>
<body>

<div class="container">

  <h2>food</h2>
  <table>
      <thead>
          <tr>
              <th>Food id</th>
              <th>Food Type</th>
              <th>Food Status</th>
              <th>Expiration Date</th>
              <th>Amount</th>
              <th>Edit</th>
      </thead>
      <tbody>
          <?php
          require_once 'db_connect.php';
          $query = "SELECT * FROM food;";
          $result_0 = $conn->query($query);
          while ($row = $result_0->fetch_assoc()):?>
            <tr>
                <td><?php echo $row['Food_id'];?></td>
                <td><?php echo $row['Food_type'];?></td>
                <td><?php echo $row['Food_status'];?></td>
                <td><?php echo $row['Expiration_date'];?></td>
                <td><?php echo $row['Amount'];?></td><!-- comment -->
                <td>
                    <form action="edit_food.php" method="post">
                        <input type="hidden" name="Food_id" value="<?php echo $row['Food_id']; ?>">
                        <button type="submit">Edit</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
      </tbody>
  </table>
<form action="add_food.php" method="post">
<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
<button class="button add-botton" type="submit">新增食物数据</button>
</form>
  <h2>表格2</h2>
  <table>
    <tr>
      <th>列1</th>
      <th>列2</th>
      <th>操作</th>
    </tr>
    <!-- 从数据库中获取表格2的数据并填充 -->
    <tr>
      <td>数据1</td>
      <td>数据2</td>
      <td><button class="button">修改</button></td>
    </tr>
    <tr>
      <td>数据3</td>
      <td>数据4</td>
      <td><button class="button">修改</button></td>
    </tr>
    <!-- 添加更多的数据行 -->
  </table>
 <button class="button add-button">新增数据</button>
  <h2>表格3</h2>
  <table>
    <tr>
      <th>列1</th>
      <th>列2</th>
      <th>操作</th>
    </tr>
    <!-- 从数据库中获取表格3的数据并填充 -->
    <tr>
      <td>数据1</td>
      <td>数据2</td>
      <td><button class="button">修改</button></td>
    </tr>
    <tr>
      <td>数据3</td>
      <td>数据4</td>
      <td><button class="button">修改</button></td>
    </tr>
    <!-- 添加更多的数据行-->
  </table>

  
  
</div>

</body>
</html>

<?php 
/*
require_once 'db_connect.php';

$stmt_0 = $conn->prepare("INSERT INTO food(Food_type, Food_status, Expiration_date, Sto_name, Amount) VALUES(?, ?, ?, ?, ?);");//添加食物记录
$stmt_0->bind_param('sssss', $food_type, $food_sttus, $expiration_date, $sto_name, $amount);
        
$stmt_1 = $conn->prepare("INSERT INTO medicine (Medicine_type, Medicine_status, Expiration_date, Store_name, Amount) VALUES (?, ?, ?, ?, ?)"); 
$stmt_1->bind_param('sssss', $medicine_type, $medicine_status, $expiration_date, $store_name, $amount);

$stmt_2 = "SELECT * FROM charity";
$result = $conn->query($stmt_2); 
if (!$result) 
     die("Fatal Error"); 
else
     echo("Query results retrieved<br/>");
        
'''*/
?>