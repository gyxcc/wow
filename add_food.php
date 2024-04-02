<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h2>Add Food</h2>
    <form method="POST" action="">

        <label>Food Type:</label>
        <input type="text" name="food_type" required><br><br>
        
        <label>Expiration Date:</label>
        <input type="password" name="expiration_date" required><br><br>
        
        <label>Amount:</label>
        <input type="password" name="amount" required><br><br>
                
        
        <input type='hidden' name='action' value='create' />
        <input type="submit" value="Log In">
    </form>
</body>
</html>
    
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once 'db_connect.php';
    $food_type = $_POST['food_type'];
    $expiration_date = $_POST['expiration_date'];
    $amount = $_POST['amount'];
    $food_status =  "new";
    $sto_name = $_SESSION['sto_name'];
    $stmt_0 = $conn->prepare("INSERT INTO food(Food_type, Food_status, Expiration_date, Sto_name, Amount) VALUES(?, ?, ?, ?, ?);");//添加食物记录
    $stmt_0->bind_param('ssssi', $food_type, $food_sttus, $expiration_date, $sto_name, $amount);
}


