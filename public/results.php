<?php
session_start();

if (!isset($_SESSION['test_results'])) {
    header('Location: index.php');
    exit;
}

$results = $_SESSION['test_results'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Результаты теста</title>
    <link rel="stylesheet" href="../static/styles.css">
</head>

<body>
    <div class="container">
        <h1>Результаты теста</h1>
        <div class="results">
            <p>Пользователь: <?= htmlspecialchars($username) ?></p>
            <p>Правильных ответов: <?= $results['correct_answers'] ?> из <?= $results['total_questions'] ?></p>
            <p>Процент набранных баллов: <?= $results['score_percentage'] ?>%</p>
        </div>
        <a href="index.php" class="button">На главную</a>
    </div>
</body>

</html>