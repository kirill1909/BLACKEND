<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Защита: если не авторизован — на страницу входа
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once 'config.php';
include_once 'header.php';

// Получаем данные текущего пользователя
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Принудительно очищаем переменную роли от невидимых пробелов
$current_role = trim($user['role']);
?>

<main class="container">
    <div class="profile-wrapper">
        
        <h1 class="categories__main-title title-spaced">Личный кабинет</h1>
        
        <p class="profile-welcome-text">
            Добро пожаловать, <strong><?= htmlspecialchars($user['username']) ?></strong>!
        </p>

        <div style="background: #222; padding: 10px; margin-bottom: 20px; border: 1px dashed #555; font-size: 12px; color: #888;">
            Отладка: Твой ID в сессии = <?= $_SESSION['user_id'] ?> | Роль в базе данных = "<?= htmlspecialchars($user['role']) ?>"
        </div>

        <?php if ($current_role === 'admin' || $_SESSION['user_id'] == 1): ?>
            
            <div class="admin-alert-box">
                <h3 class="admin-alert-box__title">Управление магазином</h3>
                <p class="admin-alert-box__text">
                    Вы авторизованы с правами администратора системы. Вам доступно редактирование каталога мерча BLACKENED.
                </p>
                <a href="admin.php" class="btn btn--dark">Перейти в админку</a>
            </div>

        <?php else: ?>
            
            <div class="orders-section">
                <h2 class="profile-section-title">История ваших заказов</h2>
                <p class="profile-empty">История заказов пуста.</p>
            </div>

        <?php endif; ?>

        <div class="profile-logout-block">
            <a href="logout.php" class="profile-logout-btn">Выйти из аккаунта</a>
        </div>

    </div>
</main>

<?php include_once 'footer.php'; ?>