<?php
session_start();

// Простейшая аутентификация
if ($_POST['password'] === 'admin') {
    $_SESSION['auth'] = true;
}
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    ?>
    <form action="dashboard.php" method="post">
        <label for="password">Введите пароль:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Войти</button>
    </form>
    <?php
    exit;
}

$results = json_decode(file_get_contents('results.json'), true);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
</head>
<body>
    <h1>Результаты тестов</h1>
    <table border="1">
        <tr>
            <th>Имя пользователя</th>
            <th>Баллы (%)</th>
            <th>Дата</th>
        </tr>
        <?php foreach ($results as $result): ?>
            <tr>
                <td><?= htmlspecialchars($result['username']) ?></td>
                <td><?= htmlspecialchars($result['score']) ?></td>
                <td><?= htmlspecialchars($result['timestamp']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">На главную</a>
</body>
</html>
