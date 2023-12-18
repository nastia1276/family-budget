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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addIncome"])) {
    $source = $_POST["source"];
    $sum = $_POST["income_sum"];
    $date = $_POST["income_date"];

    $sql = "INSERT INTO income (source, sum, date, user) VALUES ('$source', '$sum', '$date', '$user_id')";
    
    if ($conn->query($sql) === TRUE) {
        $addedSuccessfully = true;
    }
}

$conn->close();

// Перевірка чи додавання було успішним
if ($addedSuccessfully) {
    session_start();
    $_SESSION['success_message'] = "Дохід успішно додано!";
    header("Location: index.php?form=income");
    exit();
} else {
    $error_message = "Помилка при додаванні доходу";
}

// Виведення повідомлення, якщо воно є
if (isset($_SESSION['success_message'])) {
    echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}
?>

<h2>Додати доходи</h2>
<form action="" method="post">
    <label for="source">Джерело доходу:</label>
    <input type="text" id="source" name="source" required>

    <label for="income_sum">Сума:</label>
    <input type="number" id="income_sum" name="income_sum" step="0.01" pattern="[0-9]+([\.,][0-9]+)?" required>

    <label for="income_date">Дата:</label>
    <input type="date" id="date" name="income_date" required>

    <button type="submit" name="addIncome">Додати дохід</button>
</form>
