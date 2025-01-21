<?php
// Загружаем вопросы из файла JSON
$questions = json_decode(file_get_contents('questions.json'), true);
session_start();
$_SESSION['username'] = $_POST['username'] ?? 'Аноним';

if (!$questions) {
    die('Ошибка загрузки теста.');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тест</title>
</head>
<body>
    <h1>Пройдите тест</h1>
    <form action="results.php" method="post">
        <?php foreach ($questions as $index => $question): ?>
            <h3><?= htmlspecialchars($question['question']) ?></h3>
            <?php if ($question['type'] === 'radio'): ?>
                <?php foreach ($question['options'] as $option): ?>
                    <label>
                        <input type="radio" name="answer_<?= $index ?>" value="<?= htmlspecialchars($option) ?>" required>
                        <?= htmlspecialchars($option) ?>
                    </label><br>
                <?php endforeach; ?>
            <?php elseif ($question['type'] === 'checkbox'): ?>
                <?php foreach ($question['options'] as $option): ?>
                    <label>
                        <input type="checkbox" name="answer_<?= $index ?>[]" value="<?= htmlspecialchars($option) ?>">
                        <?= htmlspecialchars($option) ?>
                    </label><br>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit">Отправить</button>
    </form>
</body>
</html>
