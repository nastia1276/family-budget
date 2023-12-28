Розгортання проекту

1. Створити в phpmyadmin пусту базу даних, назвати її family_budget та обрати кодування utf8mb4_general_ci
2. Перейти в створену бд, натиснути імпорт, додати файл family_budget.sql, обрати кодування utf-8
3. Папку проекту розмістити в xampp/htdocs
3. Відкрити проект (http://localhost/назва_папки/login.php)

Вміст файлів

---------------------
db_conn.php
---------------------
Підключення до бази даних та вивід помилки в разі невдалого підключення, значення змінних зазвичай не потрібно змінювати, 
але якщо для входу в phpmyadmin створювали власний логін і пароль, то ці дані потрбіно замінити, так само і назву бази даних, відповідно до вашої назви

---------------------
login.php, register.php
------------------------
У формі для входу вказано action="login_process.php", що вказує на те, що функціонал відправки форми прописано в login_process.php
У формі реєстрації - action="register_process.php", тобто функціонал в register_process.php

---------------------
login_process.php
---------------------
Запускає нову або відновлює існуючу сесію:
   session_start()
Підключає файл db_conn.php:
   include('db_conn.php')
Отримує логін та пароль акаунту з POST-запиту відправки форми:
   $username = $_POST['username'];
   $password = $_POST['password'];
Формує запит до бази даних для перевірки чи існує користувач з такими даними в таблиці:
   $query = "SELECT * FROM family_members WHERE username='$username' AND password='$password'";
Виконує запит до бази даних та перевіряє, чи є результати:
   $result = $conn->query($query);
Якщо є користувач з введеним логіном та паролем, встановлює сесійну змінну $_SESSION['username'] з логіном користувача 
та перенаправляє його на сторінку "account" (index.php?page=account):
   if ($result->num_rows > 0) {
       $_SESSION['username'] = $username;
       header("Location: index.php?page=account");
   }
Якщо користувача не знайдено, виводить повідомлення:
   else {
       echo "Неправильний логін або пароль!";
   }
Закриває з'єднання з базою даних:
   $conn->close();

---------------------
register_process.php
---------------------
Майже всі функції такі самі як в login, з іншого:
Запит до бази даних для реєстрації нового користувача, який вставляє дані з форми в таблицю:
   $query = "INSERT INTO family_members (name, surname, age, username, password, role) 
   VALUES ('$name', '$surname', '$age', '$username', '$password', '$role')";
Якщо реєстрація пройшла успішно, перенаправляє користувача на сторінку login.php:
   if ($result) {
       header("Location: login.php");
   }

---------------------
logout.php
---------------------
Функціонал виходу з облікового запису.
session_start() - запускає нову або відновлює існуючу сесію.
session_destroy() - завершує поточну сесію, видаляючи всі дані сесії.
header("Location: login.php") - відправляє HTTP-заголовок для перенаправлення браузера на іншу сторінку, в даному випадку, на login.php.
exit() - завершує виконання скрипта.

---------------------
index.php
---------------------
На початку файлу звичайна перевірка, чи користувач ввійшов в систему
Перевіряє, чи не встановлено змінну сесії "username":
   if (!isset($_SESSION['username'])) {
Якщо змінна не встановлена, перенаправляє користувача на сторінку входу (login.php):
   header("Location: login.php");
Якщо змінна сесії вже встановлена, отримує значення цієї змінної:
   $username = $_SESSION['username'];
Далі в секції для вставки форми
Перевіряє, чи встановлені параметри GET з іменами "form" та "page":
   $formType = isset($_GET['form']) ? $_GET['form'] : '';
   $page = isset($_GET['page']) ? $_GET['page'] : '';
Якщо параметри встановлені, змінні отримують їх значення; в іншому випадку, вони отримують порожні рядки.
Далі включає відповідний файл в залежності від значень параметрів GET, а шапка і підвал сайту залишаються тими ж:
   if ($formType == 'income') {
       include('income_form.php');
   } elseif ($formType == 'expenses') {
       include('expenses_form.php');
   } elseif ($page == 'account') {
       include('account.php');
   } elseif ($page == 'approval') {
       include('approval.php');
   }

---------------------
account.php
---------------------
Сторінка акаунту, тут теж багато подібних функцій
Перевіряє, чи користувач ввійшов в систему, інакше перенаправляє на сторінку логін:
   include('db_conn.php');
   if (!isset($_SESSION['username'])) {
       header("Location: login.php");
       exit();
   }
Отримує дані про користувача з таблиці бази даних, відповідно до його логіну:
   $username = $_SESSION['username'];
   $sql = "SELECT * FROM family_members WHERE username = '$username'";
   $result = $conn->query($sql);
fetch_assoc() - використовується для витягування результату запиту до бази даних у вигляді асоціативного масиву, 
і відповідно присвоюємо значення для змінних:
   if ($result->num_rows > 0) {
       $row = $result->fetch_assoc();
       $name = $row["name"];
       $surname = $row["surname"];
       $age = $row["age"];
       $username = $row["username"];
   } else {
       echo "0 results";
   }
Виконує запити до бази даних для отримання схвалених витрат та всіх доходів:
   $query_expenses = "SELECT e.id, e.category, e.sum, e.date, f.username FROM expenses e 
   inner join family_members f on f.user_id=e.user WHERE approved = 1";
   $result_expenses = $conn->query($query_expenses);

   $query_income = "SELECT i.id, i.source, i.sum, i.date, f.username FROM income i 
   inner join family_members f on f.user_id=i.user";
   $result_income = $conn->query($query_income);

Ну тут зрозуміло, вивід даних в таблицю:
           while ($row = $result_expenses->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["category"] . "</td>";
                echo "<td>" . $row["sum"] . "</td>";
                echo "<td>" . $row["date"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "</tr>";
            }

---------------------
approval.php
---------------------
Функціонал підтвердження витрат, тут в принципі на основі вище описаного вже має бути більш менш зрозуміло
Плюс є багато коментарів для кожного блоку функціоналу в цьому файлі

-----------------------------------
expenses_form.php, income_form.php
-----------------------------------
Тут однаковий функціонал, лише різні назви колонок і таблиці бази даних

Ініціалізація змінної для початку:
   $addedSuccessfully = false;
Отримання ід користувача з бд, який ввійшов, за його логіном:
   $user = $_SESSION['username'];
   $query_user = "SELECT user_id FROM family_members WHERE username = '$user'";
   $result_user = $conn->query($query_user);

   if ($result_user->num_rows > 0) {
       $row_user = $result_user->fetch_assoc();
       $user_id = $row_user['user_id'];
   }
Перевіряємо чи метод відправки форми встановлено на POST і чи назва кнопки відправки - addExpense
Якщо так - присвоюємо змінним значення з форми
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addExpense"])) {
    $category = $_POST["category"];
    $sum = $_POST["expenses_sum"];
    $date = $_POST["expenses_date"];
Виконання запиту до бд для вставки даних, якщо запит пройшов успішно встановлюємо $addedSuccessfully на true:
    $sql = "INSERT INTO expenses (category, sum, date, user) VALUES ('$category', '$sum', '$date', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        $addedSuccessfully = true;
    }
Перевірка чи додавання було успішним, за тим, чи встановлено $addedSuccessfully як true, і встановлення значення для success_message:
   if ($addedSuccessfully) {
       session_start();
       $_SESSION['success_message'] = "Витрати успішно додано!";
       header("Location: index.php?form=expenses");
       exit();
   }
Виведення повідомлення success_message, якщо воно є
unset використовується для знищення змінної, щоб звільнити пам'ять:
   if (isset($_SESSION['success_message'])) {
       echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
       unset($_SESSION['success_message']);
   }




