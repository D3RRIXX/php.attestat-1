<?php
// includes/auth.php

/**
 * Проверка учетных данных администратора
 *
 * @param string $username Имя пользователя
 * @param string $password Пароль
 * @return bool
 */
function authenticateAdmin($username, $password)
{
    // Жестко заданныеCredentional для простоты
    $validUsername = 'admin';
    $validPassword = 'admin123';

    return ($username === $validUsername && $password === $validPassword);
}

/**
 * Старт сессии для администратора
 *
 * @param string $username Имя пользователя
 */
function loginAdmin($username)
{
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_username'] = $username;
}

/**
 * Проверка авторизации администратора
 *
 * @return bool
 */
function isAdminLoggedIn()
{
    session_start();
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Выход администратора
 */
function logoutAdmin()
{
    session_start();
    unset($_SESSION['admin_logged_in']);
    unset($_SESSION['admin_username']);
    session_destroy();
}