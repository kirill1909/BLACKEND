<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLACKENED — Каталог товаров</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <?php include_once 'header.php'; ?>

    <main class="container">
        <div class="breadcrumbs">
            <a href="index.php">Главная</a> / <span>Каталог</span>
        </div>

        <h1 class="categories__main-title title-spaced">Полный каталог мерча</h1>
        <div class="sort-panel">
            <span class="sort-panel__label">Сортировать:</span>
            <button class="btn btn--dark btn--mini">По цене</button>
            <button class="btn btn--secondary btn--mini">По новизне</button>
        </div>

        <div class="categories__grid">
            
            <div class="product-card"> 
                <img src="images/hoodie.webp" alt="Зип-худи" class="product-card__img">
                <div class="product-card__info">
                    <h3 class="product-card__title">Зип-худи «Scourge of God»</h3>
                    <p class="product-card__subtitle">Плотность 460г, трехнитка</p>
                    <div class="product-card__row">
                        <span class="product-card__price">24 000 ₸</span>
                        <a href="hoodie.php" class="btn btn--dark product-card__btn">Подробнее</a>
                    </div>
                </div>
            </div>
            
             <div class="product-card">
                <img src="images/vinil.jpg" alt="Винил" class="product-card__img">
                <div class="product-card__info">
                    <h3 class="product-card__title">Пластинка Metallica — Master of Puppets</h3>
                    <p class="product-card__subtitle">180g Тяжелый черный винил</p>
                    <div class="product-card__row">
                        <span class="product-card__price">18 500 тг</span>
                        <a href="Vinil.php" class="btn btn--dark product-card__btn">Подробнее</a>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <img src="images/picks.webp" alt="Ремень" class="product-card__img">
                <div class="product-card__info">
                    <h3 class="product-card__title">Ремень для гитары «Heavy Duty»</h3>
                    <p class="product-card__subtitle">Натуральная кожа, стальные заклепки</p>
                    <div class="product-card__row">
                        <span class="product-card__price">12 000 ₸</span>
                        <a href="picks.php" class="btn btn--dark product-card__btn">Подробнее</a>
                    </div>
                </div>
            </div>
            
        </div>
    </main>

  <?php include_once 'footer.php'; ?>
</body>
</html>