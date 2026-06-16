<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>BLACKENED — Регистрация</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include_once 'header.php'; ?>

<main class="container container--form-center">
    <div class="form-box">
        <h2>Регистрация</h2>
        
        <?php if (isset($_SESSION['auth_error'])): ?>
            <p class="form-msg-error"><?= $_SESSION['auth_error']; unset($_SESSION['auth_error']); ?></p>
        <?php endif; ?>

    
        <form action="controllers/action_register.php" method="POST">
            <div class="form-group">
                <label class="form-group__label">Придумайте Логин</label>
                <input type="text" name="username" required class="form-group__input">
            </div>
            
            <div class="form-group">
                <label class="form-group__label">Пароль</label>
                <input type="password" name="password" required class="form-group__input">
            </div>
            
            <button type="submit" class="btn btn--dark btn--full">Зарегистрироваться</button>
        </form>
        
        <p class="form-box__notice">
            Уже есть аккаунт? <a href="login.php">Войти</a>
        </p>
    </div>
</main>

<?php include_once 'footer.php'; ?>
</body>
</html>
