<?php

include('db_conn.php');
// Перевірка, чи користувач ввійшов в систему
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$sql = "SELECT * FROM family_members WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row["name"];
    $surname = $row["surname"];
    $age = $row["age"];
    $username = $row["username"];
} else {
    echo "0 results";
}

$query_expenses = "SELECT e.id, e.category, e.sum, e.date, f.username FROM expenses e 
inner join family_members f on f.user_id=e.user WHERE approved = 1";
$result_expenses = $conn->query($query_expenses);

$query_income = "SELECT i.id, i.source, i.sum, i.date, f.username FROM income i 
inner join family_members f on f.user_id=i.user";
$result_income = $conn->query($query_income);

$conn->close();
?>

<h2>Інформація про користувача</h2>
<p><strong>Ім'я:</strong> <?php echo $name; ?></p>
<p><strong>Прізвище:</strong> <?php echo $surname; ?></p>
<p><strong>Вік:</strong> <?php echo $age; ?></p>
<p><strong>Логін:</strong> <?php echo $username; ?></p>

<h3>Схвалені витрати</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Категорія</th>
                <th>Сума</th>
                <th>Дата</th>
                <th>Користувач</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result_expenses->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["category"] . "</td>";
                echo "<td>" . $row["sum"] . "</td>";
                echo "<td>" . $row["date"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

<h3>Доходи</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Джерело</th>
                <th>Сума</th>
                <th>Дата</th>
                <th>Користувач</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result_income->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["source"] . "</td>";
                echo "<td>" . $row["sum"] . "</td>";
                echo "<td>" . $row["date"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
