<?php
$username = $_POST['username'];
$password = $_POST['password'];

// Підключення до бази даних
$conn = new mysqli("localhost", "root", "", "family_budget");

// Перевірка підключення
if ($conn->connect_error) {
    die("Помилка з'єднання: " . $conn->connect_error);
}

// Захищаємо пароль
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Запит до бази даних для реєстрації
$query = "INSERT INTO family_members (username, password) VALUES ('$username', '$hashedPassword')";
$result = $conn->query($query);

if ($result) {
    header("Location: login.php"); 
} else {
    echo "Помилка реєстрації!";
}

// Закриття підключення до бази даних
$conn->close();
?>
