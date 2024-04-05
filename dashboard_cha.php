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

  <h2>Available food</h2>
  <table>
      <thead>
          <tr>
              <th>Food id</th>
              <th>Food Type</th>
              <th>Food Status</th>
              <th>Expiration Date</th>
              <th>Amount</th>
      </thead>
      <tbody>
          <?php //可用的食物
          require_once 'db_connect.php';
          $query = "SELECT * FROM food where Food_status = 'available';";
          $result_0 = $conn->query($query);
          while ($row = $result_0->fetch_assoc()):?>
            <tr>
                <td><?php echo $row['Food_id'];?></td>
                <td><?php echo $row['Food_type'];?></td>
                <td><?php echo $row['Food_status'];?></td>
                <td><?php echo $row['Expiration_date'];?></td>
                <td><?php echo $row['Amount'];?></td><!-- comment -->

            </tr>
        <?php endwhile; ?>
      </tbody>
  </table>

  <h2>Available Medicine</h2>
  <table>
      <thead>
          <tr>
              <th>Medicine id</th>
              <th>Medicine Type</th>
              <th>Medicine Status</th>
              <th>Expiration Date</th>
              <th>Amount</th>

      </thead>
      <tbody>
          <?php //可用的药物
          require_once 'db_connect.php';
          $query = "SELECT * FROM medicine where Medicine_status = 'available';";
          $result_1 = $conn->query($query);
          while ($row = $result_1->fetch_assoc()):?>
            <tr>
                <td><?php echo $row['Medicine_id'];?></td>
                <td><?php echo $row['Medicine_type'];?></td>
                <td><?php echo $row['Medicine_status'];?></td>
                <td><?php echo $row['Expiration_date'];?></td>
                <td><?php echo $row['Amount'];?></td><!-- comment -->

            </tr>
        <?php endwhile; ?>
      </tbody>
  </table>

  <h2>Published Mission</h2>
  <table>
      <thead>
          <tr>
              <th>Distribution Time</th>
              <th>Gathering Point</th>
              <th>Charity Location</th>
              <th>Mission_status</th>
              <th>volunteer</th>
              <th>Edit</th>
      </thead>
      <tbody>
          <?php
          require_once 'db_connect.php';
          $query = "SELECT * FROM mission_charity_to_point;";
          $result_2 = $conn->query($query);
          while ($row = $result_2->fetch_assoc()):?>
            <tr>
                <td><?php echo $row['Distribution_time'];?></td>
                <td><?php echo $row['Gathering_point'];?></td>
                <td><?php echo $row['Charity_location'];?></td>
                <td><?php echo $row['Mission_status'];?></td>
                <td><?php echo $row['volunteer'];?></td>
                <td>
                    <form action="choose.php" method="post">
                        <input type="hidden" name="Cha_name" value="<?php echo $row['Medicine_id']; ?>">
                        <button type="submit">Choose</button>    
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
      </tbody>
  </table>
<form action="publish_new_mission.php" method="post">
<input type="hidden" name="user_id" value="<?php echo $_SESSION["user_id"]; ?>">
<button type="submit">Publish New Mission</button>    
</form>   
  <form action="change_cha.php" method="post">
<input type="hidden" name="user_id" value="<?php echo $_SESSION["user_id"]; ?>">
<button type="submit">Change Your Personal Infomation</button>    
</form>

</div>
</body>

</html>