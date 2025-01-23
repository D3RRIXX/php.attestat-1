<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (authenticateAdmin($username, $password)) {
        loginAdmin($username);
    } else {
        $error = "Неверный логин или пароль";
    }
}

if (!isAdminLoggedIn()) {
    header('Location: index.php');
    exit;
}

$testResults = getAllTestResults($pdo);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="../static/styles.css">
</head>

<body>
    <div class="container">
        <h1>Результаты тестирования</h1>
        <a href="?logout=1" class="button logout">Выйти</a>
        <table>
            <thead>
                <tr>
                    <th>Имя пользователя</th>
                    <th>Правильных ответов</th>
                    <th>Процент баллов</th>
                    <th>Дата прохождения</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($testResults as $result): ?>
                    <tr>
                        <td><?= htmlspecialchars($result['username']) ?></td>
                        <td><?= $result['correct_answers'] ?></td>
                        <td><?= $result['score_percentage'] ?>%</td>
                        <td><?= $result['test_date'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
if (isset($_GET['logout'])) {
    logoutAdmin();
    header('Location: index.php');
    exit;
}