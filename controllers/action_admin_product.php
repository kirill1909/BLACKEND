<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Защита: выполнять скрипт может только админ
if (!isset($_SESSION['user_id']) || $_SESSION['user_name'] !== 'admin') {
    die("Доступ запрещен");
}

include_once '../config.php';

$action = $_GET['action'] ?? '';

// --- ДОБАВЛЕНИЕ ТОВАРА ---
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $slug  = trim($_POST['slug']);
    $price = intval($_POST['price']);
    $image = trim($_POST['image']);

    if (!empty($title) && !empty($slug) && $price > 0) {
        $stmt = $pdo->prepare("INSERT INTO products (title, slug, price, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $price, $image]);
    }
    
    header("Location: ../admin.php");
    exit;
}

// --- УДАЛЕНИЕ ТОВАРА ---
if ($action === 'delete') {
    $id = intval($_GET['id'] ?? 0);
    
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    }
    
    header("Location: ../admin.php");
    exit;
}

// Если экшен не подошел, просто возвращаем в админку
header("Location: ../admin.php");
exit;