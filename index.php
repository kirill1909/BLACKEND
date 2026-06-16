<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLACKENED — Мерч и Тяжелая Музыка</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

   <?php include_once 'header.php'; ?>

    <main>
        <section class="promo" id="about">
            <div class="container">
                <div class="promo__banner">
                    <h1 class="promo__title">Громче, чем ад. Темнее, чем ночь.</h1>
                    <p class="promo__text">Добро пожаловать в BLACKENED — ультимативный магазин для истинных фанатов тяжелой музыки. Мы собрали здесь редкий виниловый эксклюзив, брутальный оверсайз мерч премиум-качества и самые необходимые аксессуары. Никакой попсы, только чистый дисторшн.</p>
                </div>
            </div>
        </section>

        <section class="categories">
            <div class="container">
                <h2 class="categories__main-title">Свежий Дроп / Мерч, Пластинки & Винил</h2>
                <div class="categories__grid">
                    
                    <div class="product-card">
                        <img src="images/hoodie.webp" alt="Зип-худи" class="product-card__img">
                        <div class="product-card__info">
                            <h3 class="product-card__title">Зип-худи «Scourge of God»</h3>
                            <p class="product-card__subtitle">Плотность 460г, трехнитка, шелкография</p>
                            <div class="product-card__row">
                                <span class="product-card__price">24 000 тг</span>
                                <a href="hoodie.php" class="btn btn--dark product-card__btn">Подробнее</a>
                            </div>
                        </div>
                    </div>

                    <div class="product-card">
                        <img src="images/vinil.jpg" alt="Винил" class="product-card__img">
                        <div class="product-card__info">
                            <h3 class="product-card__title">Пластинка Metallica — Master of Puppets</h3>
                            <p class="product-card__subtitle">180g Тяжелый винил, оригинальный ремастер</p>
                            <div class="product-card__row">
                                <span class="product-card__price">18 500 тг</span>
                                <a href="vinil.php" class="btn btn--dark product-card__btn">Подробнее</a>
                            </div>
                        </div>
                    </div>

                    <div class="product-card">
                        <img src="images/picks.webp" alt="Ремень" class="product-card__img">
                        <div class="product-card__info">
                            <h3 class="product-card__title">Ремень для гитары «Heavy Duty»</h3>
                            <p class="product-card__subtitle">Натуральная кожа, стальные заклепки</p>
                            <div class="product-card__row">
                                <span class="product-card__price">12 000 тг</span>
                                <a href="picks.php" class="btn btn--dark product-card__btn">Подробнее</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <?php include_once 'footer.php'; ?>

</body>
</html>