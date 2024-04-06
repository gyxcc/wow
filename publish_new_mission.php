<!DOCTYPE html>
<html>
<head>
    <title>Publish New Missions</title>
</head>
<body>
    <h2>Publish New Missions</h2>
    <form method="POST" action="">

        <label>DATE(YYYY-MM-DD)</label>
        <input type="text" name="food_type" required><br><br>
        
        <label>START TIME:</label>
        <input type="text" name="expiration_date" required><br><br>
        
        <label>Gathering Point</label>
        <input type="text" name="amount" required><br><br>
                
        
        <input type='hidden' name='action' value='create' />
        <input type="submit" value="Log In">
    </form>
    
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
          $query = "SELECT * FROM food;";
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
          $query = "SELECT Medicine_id, Medicine_type, Medicine_status, Expiration_date, Amount FROM medicine;";
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
      
      </form>
  <?php 
  
  ?>
</body>
</html>
