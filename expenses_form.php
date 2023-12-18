<?php
include('db_conn.php');
$addedSuccessfully = false;
$user = $_SESSION['username'];

$query_user = "SELECT user_id FROM family_members WHERE username = '$user'";
$result_user = $conn->query($query_user);

if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $user_id = $row_user['user_id'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addExpense"])) {
    $category = $_POST["category"];
    $sum = $_POST["expenses_sum"];
    $date = $_POST["expenses_date"];

    $sql = "INSERT INTO expenses (category, sum, date, user) VALUES ('$category', '$sum', '$date', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        $addedSuccessfully = true;
    }
}

$conn->close();

// Перевірка чи додавання було успішним
if ($addedSuccessfully) {
    session_start();
    $_SESSION['success_message'] = "Витрати успішно додано!";
    header("Location: index.php?form=expenses");
    exit();
} else {
    $error_message = "Помилка при додаванні витрат";
}

// Виведення повідомлення, якщо воно є
if (isset($_SESSION['success_message'])) {
    echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}
?>

<h2>Додати витрати</h2>
<form action="" method="post">
    <label for="category">Категорія:</label>
    <select id="category" name="category">
        <option value="food">Їжа</option>
        <option value="rent">Оренда</option>
        <option value="utilities">Комунальні послуги</option>
    </select>

    <label for="expenses_sum">Сума:</label>
    <input type="number" id="amount" name="expenses_sum" step="0.01" pattern="[0-9]+([\.,][0-9]+)?" required>

    <label for="expenses_date">Дата:</label>
    <input type="date" id="date" name="expenses_date" required>

    <button type="submit" name="addExpense">Додати витрату</button>
</form>
