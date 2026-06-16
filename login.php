<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>BLACKENED — Войти</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include_once 'header.php'; ?>

<main class="container container--form-center">
    <div class="form-box">
        <h2>Авторизация</h2>
        
        <?php if (isset($_SESSION['auth_error'])): ?>
            <p class="form-msg-error"><?= $_SESSION['auth_error']; unset($_SESSION['auth_error']); ?></p>
        <?php endif; ?>

    <form action="controllers/action_login.php" method="POST">
    <div class="form-group">
        <label class="form-group__label">Логин / Имя пользователя</label>
        <input type="text" name="username" required class="form-group__input">
    </div>
    
    <div class="form-group">
        <label class="form-group__label">Пароль</label>
        <input type="password" name="password" required class="form-group__input">
    </div>
    
    <button type="submit" class="btn btn--dark btn--full">Войти</button>
</form>
        
        <p class="form-box__notice">
            Ещё нет аккаунта? <a href="registration.php">Зарегистрироваться</a>
        </p>
    </div>
</main>

<?php include_once 'footer.php'; ?>
</body>
</html>