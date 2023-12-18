<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "family_budget";

// Підключення до бази даних
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка підключення
if ($conn->connect_error) {
    die("Помилка з'єднання: " . $conn->connect_error);
}
?>