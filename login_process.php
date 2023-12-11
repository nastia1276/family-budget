<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Підключення до бази даних
$conn = new mysqli("localhost", "root", "", "family_budget");

// Перевірка підключення
if ($conn->connect_error) {
    die("Помилка з'єднання: " . $conn->connect_error);
}

// Запит до бази даних для входу
$query = "SELECT * FROM family_members WHERE username='$username' AND password='$password'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Користувача знайдено, робимо вхід
    $_SESSION['username'] = $username;
    header("Location: index.php"); // Перенаправляємо на головну сторінку після входу
} else {
    echo "Неправильний логін або пароль!";
}

// Закриття підключення до бази даних
$conn->close();
?>
