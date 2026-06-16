<?php 
include_once 'header.php'; 

$current_slug = basename($_SERVER['PHP_SELF'], ".php");

$stmt = $pdo->prepare("SELECT * FROM products WHERE slug = ?");
$stmt->execute([$current_slug]);
$product = $stmt->fetch();

if (!$product) {
    echo "<div class='container'><h2>Товар не найден</h2></div>";
    include_once 'footer.php';
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>BLACKENED — <?= htmlspecialchars($product['title']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<main class="container">
    <div class="breadcrumbs">
        <a href="index.php">Главная</a> / <a href="product_list.php">Каталог</a> / <span><?= htmlspecialchars($product['title']) ?></span>
    </div>

    <div class="product-page">
        <div class="product-page__image">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Товар">
        </div>

        <div class="product-page__info">
            <h1 class="product-title"><?= htmlspecialchars($product['title']) ?></h1>
            <p class="product-subtitle">Категория премиум мерча BLACKENED.</p>
            
            <div class="product-price-block">
                <span class="product-price"><?= number_format($product['price'], 0, '.', ' ') ?> ₸</span>
            </div>

<form action="controllers/action_add_product.php?action=add" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                
                <div class="quantity-selector">
                    <label for="quantity">Количество:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="10" class="quantity-input">
                </div>
                
                <button type="submit" class="btn btn--dark">Добавить в корзину</button>
            </form>
        </div>
    </div>
</main>

<?php include_once 'footer.php'; ?>
</body>
</html>