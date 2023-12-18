<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div class="container">
        <h2>Вхід в систему</h2>
        <form action="login_process.php" method="post">
            <label for="username">Логін:</label>
            <input type="text" name="username" required><br>
            <label for="password">Пароль:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Увійти</button>
        </form>
        <a href="register.php" class="register">Перейти до реєстрації</a>
    </div>
</body>
</html>
