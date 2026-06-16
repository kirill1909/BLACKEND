<?php
// Обязательно запускаем сессию, чтобы работали корзина и профиль пользователя
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'config.php'; 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLACKENED | Мерч-шоп</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="header">
    <div class="container header__wrapper">
        <div class="logo">
            <a href="index.php">
                <h1>BLACK<span>ENED</span></h1>
            </a>
        </div>
        <nav class="nav">
            <a href="index.php" class="nav__link">Главная</a>
            <a href="product_list.php" class="nav__link">Каталог</a>
            
            <a href="basket.php" class="cart-link">
                Корзина (<?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>)
            </a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profile.php" class="nav__link">Профиль</a>
                <span class="nav__user-name">| <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <a href="logout.php" class="btn btn--dark btn--mini">Выйти</a>
            <?php else: ?>
                <a href="login.php" class="btn btn--dark btn--mini">Войти</a>
                <a href="registration.php" class="btn btn--secondary btn--mini">Регистрация</a>
            <?php endif; ?>
        </nav>
    </div>
</header>