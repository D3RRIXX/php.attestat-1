<?php
session_start();
$questions = json_decode(file_get_contents('questions.json'), true);
$username = $_SESSION['username'] ?? 'Аноним';
$userAnswers = $_POST;

$correctAnswers = 0;
$totalQuestions = count($questions);

// Подсчёт правильных ответов
foreach ($questions as $index => $question) {
    if ($question['type'] === 'radio' && $userAnswers["answer_$index"] === $question['correct']) {
        $correctAnswers++;
    }
    if ($question['type'] === 'checkbox' && isset($userAnswers["answer_$index"])) {
        sort($userAnswers["answer_$index"]);
        sort($question['correct']);
        if ($userAnswers["answer_$index"] === $question['correct']) {
            $correctAnswers++;
        }
    }
}

$score = round(($correctAnswers / $totalQuestions) * 100, 2);

// Сохранение результата
$results = json_decode(file_get_contents('results.json'), true) ?? [];
$results[] = [
    'username' => $username,
    'score' => $score,
    'timestamp' => date('Y-m-d H:i:s')
];
file_put_contents('results.json', json_encode($results, JSON_PRETTY_PRINT));

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результаты</title>
</head>
<body>
    <h1>Ваши результаты</h1>
    <p>Количество правильных ответов: <?= $correctAnswers ?> из <?= $totalQuestions ?></p>
    <p>Ваш результат: <?= $score ?>%</p>
    <a href="index.php">На главную</a>
</body>
</html>
