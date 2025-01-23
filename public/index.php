<?php
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Тестирование</title>
    <link rel="stylesheet" href="../static/styles.css">
</head>

<body>
    <div class="container">
        <h1>Онлайн-тестирование</h1>
        <p>Нажмите кнопку ниже, чтобы начать тест</p>
        <a href="test.php" class="button">Пройти тест</a>
        <div class="admin-login">
            <h3>Вход для администратора</h3>
            <form action="dashboard.php" method="post">
                <input type="text" name="username" placeholder="Логин" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <button type="submit">Войти</button>
            </form>
        </div>
    </div>
</body>

</html>