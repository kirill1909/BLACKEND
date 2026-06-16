<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'config.php';

// 1. Проверяем авторизацию
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$current_user_id = intval($_SESSION['user_id']);

// 2. Получаем данные пользователя напрямую из БД
$stmt_check = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt_check->execute([$current_user_id]);
$user_data = $stmt_check->fetch();

if (!$user_data) {
    header("Location: login.php");
    exit;
}

$role = strtolower(trim($user_data['role']));
$username = strtolower(trim($user_data['username']));

// 3. Железобетонная проверка: пускаем, если ID=1 ИЛИ роль=admin ИЛИ имя=admin
if ($current_user_id !== 1 && $role !== 'admin' && $username !== 'admin') {
    header("Location: index.php");
    exit;
}

// 4. Подключаем шапку только после успешной проверки
include_once 'header.php';

// 5. Загружаем данные для админки
$stmt_products = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt_products->fetchAll();

$stmt_orders = $pdo->query("
    SELECT o.*, u.username 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    ORDER BY o.created_at DESC
");
$orders = $stmt_orders->fetchAll();
?>

<main class="container">
    <div class="profile-wrapper">
        
        <h1 class="categories__main-title title-spaced admin-title-main">Панель администратора</h1>
        <p class="admin-user-info">Текущий пользователь: <strong><?= htmlspecialchars($user_data['username']) ?></strong></p>
        
        <hr class="admin-section-divider">

        <h2 class="profile-section-title">Заказы пользователей</h2>
        
        <?php if (empty($orders)): ?>
            <p class="profile-empty">На данный момент никто из пользователей не совершил ни одного заказа.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID Заказа</th>
                        <th>Покупатель</th>
                        <th>Дата оформления</th>
                        <th>Состав заказа (Товары)</th>
                        <th>Итоговая сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><strong>#<?= $order['id'] ?></strong></td>
                            <td><?= htmlspecialchars($order['username']) ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                            <td>
                                <ul class="order-items-list" style="list-style: none; padding: 0;">
                                    <?php
                                    $stmt_items = $pdo->prepare("
                                        SELECT oi.quantity, p.title, p.price 
                                        FROM order_items oi
                                        JOIN products p ON oi.product_id = p.id
                                        WHERE oi.order_id = ?
                                    ");
                                    $stmt_items->execute([$order['id']]);
                                    $items = $stmt_items->fetchAll();
                                    
                                    foreach ($items as $item): 
                                    ?>
                                        <li>
                                            <?= htmlspecialchars($item['title']) ?> 
                                            <strong>x<?= $item['quantity'] ?></strong> 
                                            (<?= number_format($item['price'] * $item['quantity'], 0, '.', ' ') ?> ₸)
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td><span class="product-card__price"><?= number_format($order['total_price'], 0, '.', ' ') ?> ₸</span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <hr class="admin-section-divider">

        <h2 class="profile-section-title">Добавить новый товар в каталог</h2>
        <form action="controllers/action_add_product.php?action=add" method="POST" class="admin-form">
            <div class="form-group">
                <label class="form-group__label">Название товара:</label>
                <input type="text" name="title" required class="form-group__input">
            </div>
            <div class="form-group">
                <label class="form-group__label">Slug (URL имя, например: hoodie):</label>
                <input type="text" name="slug" required class="form-group__input">
            </div>
            <div class="form-group">
                <label class="form-group__label">Цена (₸):</label>
                <input type="number" name="price" required class="form-group__input">
            </div>
            <div class="form-group-large">
                <label class="form-group__label">Путь к изображению (например: images/vinil.jpg):</label>
                <input type="text" name="image" required class="form-group__input">
            </div>
            <button type="submit" class="btn btn--dark">Добавить в базу</button>
        </form>

        <hr class="admin-section-divider">

        <h2 class="profile-section-title">Список товаров в магазине</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Фото</th>
                    <th>Название</th>
                    <th>Slug</th>
                    <th>Цена</th>
                    <th>Действие</th>
                </tr>
            </table>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><img src="<?= htmlspecialchars($product['image']) ?>" alt="" class="admin-table__img"></td>
                        <td><?= htmlspecialchars($product['title']) ?></td>
                        <td><code><?= htmlspecialchars($product['slug']) ?></code></td>
                        <td><?= number_format($product['price'], 0, '.', ' ') ?> ₸</td>
                        <td>
                            <a href="controllers/action_add_product.php?action=delete&id=<?= $product['id'] ?>" 
                               onclick="return confirm('Вы уверены, что хотите удалить этот товар?');" 
                               class="admin-delete-link">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
</main>

<?php include_once 'footer.php'; ?>