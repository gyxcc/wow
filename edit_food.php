<head>
        <meta charset="UTF-8">
        <title>Edit Page</title>
</head>
    <body>
    <?php $Food_id = $_POST['Food_id'];
echo "Received id: $Food_id";?>
<form action='#' method='post' border='0'>
    

        <tr>
            <td> Food Status</td>
            <td><input type='text' name='food_status' /></td>
        </tr>
        <tr>
            <td> Food type</td>
            <td><input type='text' name='food_type' /></td>
        </tr>
        <tr>
            <td> Amount </td>
            <td><input type='text' name='amount' /></td>
        </tr>
            <td></td>
            <td>
                <input type='hidden' name='action' value='edit' />
                <input type="hidden" name="Food_id" value="<?php echo $Food_id; ?>">
                <input type='submit' value='Edit record' /><br /><br />
            </td>
        </tr>
    </table>
    
</form>
<?php

if (isset($_POST['action'])) 
    $action = $_POST['action']; 
else
    $action = ""; 

if ($action == 'edit') {
    require_once 'db_connect.php';
    $food_status = $_POST['food_status'];
    $food_type = $_POST['food_type'];
    $amount = $_POST['amount'];
    $Food_id = $_POST['Food_id'];
    $stmt = $conn->prepare('UPDATE food SET Food_type = ?, Food_status = ?, Amount = ? WHERE Food_id = ?');
    $stmt->bind_param('sssi', $food_type, $food_status, $amount, $Food_id);
    $stmt->execute();
    $error = $stmt->error;
    $stmt->close();
    $conn->close(); 
    exit;
    }
?>
<form action="dashboard_sto.php" method="get">
<button type="submit">Back to Main Page</button>
</form>
</body>
