<?php
// Обязательно проверяем/запускаем сессию в самом начале
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['cart'])) {
    $user_id = $_SESSION['user_id'] ?? null;
    $customer_name = trim($_POST['customer_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if (!empty($customer_name) && !empty($phone) && !empty($address)) {
        try {
            $pdo->beginTransaction();

            // 1. Сначала вытаскиваем товары, чтобы рассчитать полную стоимость заказа
            $product_ids = array_keys($_SESSION['cart']);
            $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
            $stmt_products = $pdo->prepare("SELECT id, price FROM products WHERE id IN ($placeholders)");
            $stmt_products->execute($product_ids);
            $products = $stmt_products->fetchAll();

            $total_price = 0;
            foreach ($products as $product) {
                $quantity = $_SESSION['cart'][$product['id']];
                $total_price += (float)$product['price'] * (int)$quantity;
            }

            // 2. Добавляем total_price в SQL-запрос вставки заказа
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, customer_name, phone, address, total_price, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$user_id, $customer_name, $phone, $address, $total_price]);
            $order_id = $pdo->lastInsertId();

            // 3. Записываем каждую позицию в таблицу order_items
            $stmt_item = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($products as $product) {
                $quantity = $_SESSION['cart'][$product['id']];
                $stmt_item->execute([$order_id, $product['id'], $quantity, $product['price']]);
            }

            $pdo->commit();
            unset($_SESSION['cart']); // Очищаем корзину после успешной оплаты

            echo "<script>
                    alert('Заказ успешно оформлен! Номер заказа: #" . $order_id . "');
                    window.location.href = 'profile.php';
                  </script>";
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            die("Ошибка сохранения: " . $e->getMessage());
        }
    }
}
header("Location: order.php");
exit;
