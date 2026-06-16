<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>BLACKENED — Оформление Заказа</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php 
include_once 'header.php'; 

if (empty($_SESSION['cart'])) {
    header("Location: product_list.php");
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo "<div class='container auth-notice-container'>
            <h2>Для оформления заказа необходимо войти в систему</h2><br>
            <a href='login.php' class='btn btn--dark'>Войти в аккаунт</a>
          </div>";
    include_once 'footer.php';
    exit;
}
?>

<main class="container container--form-center">
    <h1 class="categories__main-title title-spaced">Информация о доставке</h1>

    <div class="form-box">
        <form action="save-order.php" method="POST">
            <div class="form-group">
                <label class="form-group__label">Ваше Имя и Фамилия *</label>
                <input type="text" name="customer_name" required class="form-group__input" value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-group__label">Контактный телефон *</label>
                <input type="tel" name="phone" required placeholder="+7 (___) ___-__-__" class="form-group__input">
            </div>
            <div class="form-group-large">
                <label class="form-group__label">Адрес доставки *</label>
                <input type="text" name="address" required class="form-group__input">
            </div>
            <button type="submit" class="btn btn--dark btn--full">Подтвердить заказ</button>
        </form>
    </div>
</main>

<?php include_once 'footer.php'; ?>
</body>
</html>