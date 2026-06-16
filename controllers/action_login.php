<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Ищем пользователя в таблице users
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && $password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            unset($_SESSION['auth_error']); // Очищаем прошлые ошибки входа
            
            // Успех: перенаправляем на главную
            header("Location: ../index.php");
            exit;
        }
    }

    $_SESSION['auth_error'] = "Неверный логин или пароль";
    header("Location: ../login.php");
    exit;
}

header("Location: ../login.php");
exit;