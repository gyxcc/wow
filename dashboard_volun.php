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
          <h2>Missions from Store to Charity</h2>
  <table>
      <thead>
          <tr>
              <th>Char_Name</th>
              <th>Location</th>
              <th>Head_Name</th>
              <th>Head_Contact_Num</th>
              <th>Choose</th>
      </thead>
      <tbody>
          <?php
          require_once 'db_connect.php';
          $query = "SELECT * FROM mission_charity_to_point;";
          $result_0 = $conn->query($query);
          while ($row = $result_0->fetch_assoc()):?>
            <tr>
                <td><?php echo $row['Distribution_time'];?></td>
                <td><?php echo $row['Gathering_point'];?></td>
                <td><?php echo $row['Charity_location'];?></td>
                <td><?php echo $row['Mission_status'];?></td>
                <td>
                    <form action="wait.php" method="post">
                        <input type="hidden" name="Cha_name" value="<?php echo $row['Medicine_id']; ?>">
                        <button type="submit">Choose</button>    
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
      </tbody>
  </table>
      <h2>Missions from Charity to Gathering Point</h2>
  <table>
      <thead>
          <tr>
              <th>Char_Name</th>
              <th>Location</th>
              <th>Head_Name</th>
              <th>Head_Contact_Num</th>
              <th>Choose</th>
      </thead>
      <tbody>
          <?php
          require_once 'db_connect.php';
          $query = "SELECT * FROM mission_store_to_cha;";
          $result_0 = $conn->query($query);
          while ($row = $result_0->fetch_assoc()):?>
            <tr>
                <td><?php echo $row['Store_available_start_time'];?></td>
                <td><?php echo $row['Store_available_end_time'];?></td>
                <td><?php echo $row['Store_location'];?></td>
                <td><?php echo $row['Stuff_quantities'];?></td>
                <td><?php echo $row['Type_of_stuff'];?></td>
                <td><?php echo $row['Mission_Status'];?></td>
                <td>
                    <form action="wait.php" method="post">
                        <input type="hidden" name="Cha_name" value="<?php echo $row['Medicine_id']; ?>">
                        <button type="submit">Choose</button>    
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
      </tbody>
  </table>
</div>


