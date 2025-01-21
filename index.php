<?php
// index.php — главная страница
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
</head>
<body>
    <h1>Добро пожаловать!</h1>
    <form action="test.php" method="post">
        <label for="username">Введите ваше имя:</label>
        <input type="text" id="username" name="username" required>
        <button type="submit">Пройти тест</button>
    </form>
</body>
</html>
