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
          $query = "SELECT * FROM charity;";
          $result_0 = $conn->query($query);
          while ($row = $result_0->fetch_assoc()):?>
            <tr>
                <td><?php echo $row['Char_Name'];?></td>
                <td><?php echo $row['Location'];?></td>
                <td><?php echo $row['Head_Name'];?></td>
                <td><?php echo $row['Head_Contact_Num'];?></td>
                <td>
                <input type="checkbox">
                </td>
            </tr>
        <?php endwhile; ?>
      </tbody>
  </table>
<button onclick="handleSelection()">操作选中数据</button>
