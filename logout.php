<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Полностью очищаем и уничтожаем сессию пользователя
$_SESSION = [];
session_destroy();

// Перенаправляем человека на главную страницу
header("Location: index.php");
exit;
