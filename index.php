<?php
session_start();

// Перевірка, чи користувач ввійшов в систему
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сімейний бюджет</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

    <header>
        <h1>Сімейний бюджет</h1>
        <a href="logout.php" class="logout">Logout</a>
    </header>

    <section>
        <h2>Додати витрати</h2>
        <form action="#" method="post">
            <label for="category">Категорія:</label>
            <select id="category" name="category">
                <option value="food">Їжа</option>
                <option value="rent">Оренда</option>
                <option value="utilities">Комунальні послуги</option>
            </select>

            <label for="amount">Сума:</label>
            <input type="number" id="amount" name="amount" required>

            <label for="date">Дата:</label>
            <input type="date" id="date" name="date" required>

            <button type="submit">Додати витрату</button>
        </form>
    </section>

    <footer>
    </footer>

</body>
</html>
