<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Подключаем config.php из корня (на один уровень выше)
include_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $_SESSION['auth_error'] = "Этот логин уже занят!";
            header("Location: ../registration.php");
            exit;
        }

        // Явно пишем роль 'user' при регистрации нового аккаунта
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
        if ($stmt->execute([$username, $password])) {
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $username;
            
            header("Location: ../index.php");
            exit;
        }
    }
    
    $_SESSION['auth_error'] = "Пожалуйста, заполните все поля!";
    header("Location: ../registration.php");
    exit;
}