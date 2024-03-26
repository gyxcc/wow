<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'db_connect.php'; // include database connection file

    // Retrieve form data
    $forename = $_POST[''];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (forename, surname, username, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $forename, $surname, $username, $hashedPassword);
    $stmt->execute();

    // Redirect to login page or display a success message
    header("Location: authenticate.php");
    exit();
}
?>
