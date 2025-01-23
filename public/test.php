<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

$questions = loadQuestions();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userAnswers = $_POST['answers'] ?? [];
    $username = $userAnswers[0][0] ?? 'Анонимный пользователь';
    unset($userAnswers[0]); // Удаляем вопрос с именем

    $testResults = validateTestAnswers($userAnswers, $questions);
    saveTestResults($username, $testResults, $pdo);

    $_SESSION['test_results'] = $testResults;
    $_SESSION['username'] = $username;
    header('Location: results.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Прохождение теста</title>
    <link rel="stylesheet" href="../static/styles.css">
</head>
<body>
    <div class="container">
        <h1>Тестирование</h1>
        <form method="post">
            <?php foreach ($questions as $index => $question): ?>
                <div class="question">
                    <h3><?= htmlspecialchars($question['text']) ?></h3>
                    
                    <?php if ($index === 0): ?>
                        <input type="text" name="answers[<?= $index ?>][]" placeholder="Введите ваше имя" required>
                    <?php else: ?>
                        <?php foreach ($question['options'] as $optionIndex => $option): ?>
                            <?php if ($question['type'] === 'single'): ?>
                                <label>
                                    <input type="radio" name="answers[<?= $index ?>][]" value="<?= $optionIndex ?>" required>
                                    <?= htmlspecialchars($option) ?>
                                </label>
                            <?php else: ?>
                                <label>
                                    <input type="checkbox" name="answers[<?= $index ?>][]" value="<?= $optionIndex ?>">
                                    <?= htmlspecialchars($option) ?>
                                </label>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="button">Завершить тест</button>
        </form>
    </div>
</body>
</html>