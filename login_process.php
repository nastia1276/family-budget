<?php
session_start();
include('db_conn.php');

$username = $_POST['username'];
$password = $_POST['password'];

// Запит до бази даних для входу
$query = "SELECT * FROM family_members WHERE username='$username' AND password='$password'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Користувача знайдено, робимо вхід
    $_SESSION['username'] = $username;
    header("Location: index.php?page=account");
} else {
    echo "Неправильний логін або пароль!";
}

$conn->close();
?>
