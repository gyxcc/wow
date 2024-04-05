<!DOCTYPE html>
<html>
<head>
    <title>Pre Login</title>
</head>
<body>
    <h1>Welcome to Pre-login Site</h1>
    <p>You Are:</p>
    <form method="post" action="pre_login.php">
        <input type="radio" name="identity" value="user1"> Store<br>
        <input type="radio" name="identity" value="user2"> Charity<br>
        <input type="radio" name="identity" value="user3"> volunteer<br><br>
        <input type="submit" value="submit">
    </form>
</body>
</html>
<?php
 if (isset($_POST['identity'])) {
$identity = $_POST['identity'];

if ($identity === 'user1') {
    header('Location: register_sto.php');
    exit;
} elseif ($identity === 'user2') {
    header('Location: register_cha.php');
    exit;
} elseif ($identity === 'user3') {
    header('Location: register_volun.php');
    exit;
} else {
    echo 'Non Exist Identit';
}
}
?>
