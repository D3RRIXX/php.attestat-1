<?php
// includes/functions.php

/**
 * Загрузка вопросов из JSON файла
 *
 * @return array
 */
function loadQuestions() {
    $questionsFile = __DIR__ . '/../data/questions.json';
    $questionsJson = file_get_contents($questionsFile);
    return json_decode($questionsJson, true);
}

/**
 * Валидация ответов пользователя
 *
 * @param array $userAnswers Ответы пользователя
 * @param array $questions Список вопросов
 * @return array Результаты теста
 */
function validateTestAnswers($userAnswers, $questions) {
    $correctAnswers = 0;
    $totalQuestions = count($questions) - 1; // Вычитаем вопрос с именем

    foreach ($questions as $index => $question) {
        if ($index === 0) continue; // Пропускаем первый вопрос (имя)

        $userAnswer = $userAnswers[$index] ?? [];
        $isCorrect = false;

        if ($question['type'] === 'single') {
            $isCorrect = $userAnswer[0] == $question['correct'];
        } elseif ($question['type'] === 'multiple') {
            $isCorrect = count(array_diff($userAnswer, $question['correct'])) === 0 &&
                         count(array_diff($question['correct'], $userAnswer)) === 0;
        }

        if ($isCorrect) {
            $correctAnswers++;
        }
    }

    $percentScore = round(($correctAnswers / $totalQuestions) * 100, 2);

    return [
        'correct_answers' => $correctAnswers,
        'total_questions' => $totalQuestions,
        'score_percentage' => $percentScore
    ];
}

/**
 * Сохранение результатов теста
 *
 * @param string $username Имя пользователя
 * @param array $testResults Результаты теста
 * @param PDO $pdo Подключение к базе данных
 */
function saveTestResults($username, $testResults, $pdo) {
    $stmt = $pdo->prepare("INSERT INTO test_results (username, correct_answers, total_questions, score_percentage, test_date) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([
        $username,
        $testResults['correct_answers'],
        $testResults['total_questions'],
        $testResults['score_percentage']
    ]);
}

/**
 * Получение всех результатов тестов
 *
 * @param PDO $pdo Подключение к базе данных
 * @return array Результаты тестов
 */
function getAllTestResults($pdo) {
    $stmt = $pdo->query("SELECT * FROM test_results ORDER BY test_date DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}