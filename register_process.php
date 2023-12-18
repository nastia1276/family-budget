<?php
include('db_conn.php');

$name = $_POST['name'];
$surname = $_POST['surname'];
$age = $_POST['age'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// Запит до бази даних для реєстрації
$query = "INSERT INTO family_members (name, surname, age, username, password, role) 
VALUES ('$name', '$surname', '$age', '$username', '$password', '$role')";
$result = $conn->query($query);

if ($result) {
    header("Location: login.php"); 
} else {
    echo "Помилка реєстрації!";
}

$conn->close();
?>
