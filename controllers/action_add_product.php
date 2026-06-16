<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../config.php';

$action = $_GET['action'] ?? '';

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity'] ?? 1);

    if ($product_id > 0 && $quantity > 0) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
}

header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../product_list.php'));
exit;
