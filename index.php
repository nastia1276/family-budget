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
        <nav>
            <ul>
                <li><a href="?page=account">Особистий кабінет</a></li>
                <li><a href="?form=expenses">Додати витрати</a></li>
                <li><a href="?form=income">Додати доходи</a></li>
                <li><a href="?page=approval">Не підтверджені витрати</a></li>
                <li><a href="logout.php">Вийти з системи</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <?php
            $formType = isset($_GET['form']) ? $_GET['form'] : '';
            $page = isset($_GET['page']) ? $_GET['page'] : '';
            if ($formType == 'income') {
                include('income_form.php');
            } elseif ($formType == 'expenses') {
                include('expenses_form.php');
            } elseif ($page == 'account') {
                include('account.php');
            } elseif ($page == 'approval') {
                include('approval.php');
            }
        ?>
    </section>

    <footer>
    </footer>

</body>
</html>