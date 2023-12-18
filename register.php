<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div class="container">
        <h2>Реєстрація</h2>
        <form action="register_process.php" method="post">
            <label for="name">Ім'я:</label>
            <input type="text" name="name" required><br>
            <label for="surname">Прізвище:</label>
            <input type="text" name="surname" required><br>
            <label for="age">Вік:</label>
            <input type="text" name="age" required><br>
            <label for="username">Логін:</label>
            <input type="text" name="username" required><br>
            <label for="password">Пароль:</label>
            <input type="password" name="password" required><br>
            <label for="role">Роль:</label>
            <input type="text" name="role" required><br>
            <button type="submit">Зареєструватися</button>
        </form>
    </div> 
</body>
</html>
