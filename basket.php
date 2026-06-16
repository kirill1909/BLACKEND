<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'config.php'; 

// ==========================================
// ЛОГИКА УДАЛЕНИЯ (Выполняется до вывода HTML)
// ==========================================
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    
    // Перезагружаем эту же страницу, чтобы очистить URL от ?action=delete
    header("Location: basket.php");
    exit;
}

// Подключаем шапку (она пойдёт уже после обработки логики)
include_once 'header.php'; 

$cart_products = [];
$total_sum = 0;

if (!empty($_SESSION['cart'])) {
    $product_ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($product_ids);
    $cart_products = $stmt->fetchAll();
}
?>

<main class="container">
    <h1 class="categories__main-title title-spaced">Твоя корзина</h1>

    <?php if (!empty($cart_products)): ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_products as $product): 
                    $quantity = $_SESSION['cart'][$product['id']];
                    $item_subtotal = $product['price'] * $quantity;
                    $total_sum += $item_subtotal;
                ?>
                    <tr>
                        <td class="cart-table__item">
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Превью" class="cart-table__img">
                            <span class="cart-table__name"><?= htmlspecialchars($product['title']) ?></span>
                        </td>
                        <td class="cart-table__price"><?= number_format($product['price'], 0, '.', ' ') ?> ₸</td>
                        <td><input type="number" value="<?= $quantity ?>" class="cart-table__input" readonly></td>
                        <td class="cart-table__price"><?= number_format($item_subtotal, 0, '.', ' ') ?> ₸</td>
                        <td>
                            <a href="basket.php?action=delete&id=<?= $product['id'] ?>" 
                               onclick="return confirm('Вы действительно хотите удалить этот товар из корзины?');" 
                               class="admin-delete-link">
                               Удалить
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-summary">
            <div class="cart-summary__label">
                Итого к оплате: <strong class="cart-summary__value"><?= number_format($total_sum, 0, '.', ' ') ?> ₸</strong>
            </div>
            <a href="order.php" class="btn btn--dark cart-summary__btn">Оформить заказ</a>
        </div>
    <?php else: ?>
        <div class="cart-empty-block">
            <p>Ваша корзина пуста.</p>
            <a href="product_list.php" class="btn btn--dark">В каталог</a>
        </div>
    <?php endif; ?>
</main>

<?php include_once 'footer.php'; ?>