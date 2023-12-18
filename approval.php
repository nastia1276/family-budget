<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Не підтверджені витрати</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<?php
include('db_conn.php');

$username = $_SESSION['username'];

// Отримання ролі користувача
$sqlRole = "SELECT role FROM family_members WHERE username = '$username'";
$resultRole = $conn->query($sqlRole);

if ($resultRole->num_rows > 0) {
    $rowRole = $resultRole->fetch_assoc();
    $userRole = $rowRole["role"];

    // Перевірка, чи користувач має роль "головний"
    if ($userRole == 'головний') {
        // Перевірка наявності POST-запиту для оновлення значень поля "approved"
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["approveExpenses"])) {
            // Отримання масиву ID витрат, які були відзначені для підтвердження
            $approvedExpenses = $_POST["approvedExpenses"];

            // Перевірка чи є вибрані витрати
            if (!empty($approvedExpenses)) {
                // Формуємо рядок для використання в запиті IN
                $approvedExpensesStr = implode(",", $approvedExpenses);

                // Оновлення полів "approved" у вибраних записах
                $sqlUpdate = "UPDATE expenses SET approved = 1 WHERE id IN ($approvedExpensesStr)";
                $conn->query($sqlUpdate);
            }
        }

        // Запит до бази даних
        $sqlSelect = "SELECT * FROM expenses WHERE approved=0";
        $result = $conn->query($sqlSelect);

        // Перевірка наявності даних
        if ($result->num_rows > 0) {
            echo '<form action="" method="post">';
            echo '<table>';
            echo '<tr><th>ID</th><th>Категорія</th><th>Сума</th><th>Дата</th><th>Підтверджено</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["id"] . '</td>';
                echo '<td>' . $row["category"] . '</td>';
                echo '<td>' . $row["sum"] . '</td>';
                echo '<td>' . $row["date"] . '</td>';
                echo '<td><input type="checkbox" name="approvedExpenses[]" value="' . $row["id"] . '"></td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '<br><button type="submit" name="approveExpenses">Підтвердити витрати</button>';
            echo '</form>';
        } else {
            echo "0 результатів";
        }
    } else {
        echo "Ви не маєте прав доступу для підтвердження витрат.";
    }
} else {
    echo "Помилка отримання ролі користувача";
}

$conn->close();
?>

</body>
</html>
