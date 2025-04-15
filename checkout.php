<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/config.php';
require 'cartfunction.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php?redirect=checkout.php');
    exit();
}

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    try {
        $conn->beginTransaction();

        $cartItems = getCartItems($conn);

        if (empty($cartItems)) {
            $error = "Votre panier est vide.";
        } else {
            $stmt = $conn->prepare("INSERT INTO user_movies (user_id, movie_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE purchase_date = CURRENT_TIMESTAMP");

            foreach ($cartItems as $item) {
                $stmt->execute([$_SESSION['user_id'], $item['movie_id']]);
            }
            clearCart($conn);

            $conn->commit();
            $success = true;
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        $error = "Une erreur est survenue: " . $e->getMessage();
    }
}

$cartItems = $success ? [] : getCartItems($conn);
$cartTotal = getTotalPrice($cartItems);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>supinstream</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="src/script.js" defer></script>
</head>

<?php require_once('header.php'); ?>
<body>
<main>
    <h1>Finalisez votre commande</h1>
    <?php if ($success): ?>
        <div class="success-message">
            <h2>Commande confirmée !</h2>
            <p>Vos films ont été ajoutés à votre espace personnel.</p>
            <p>Vous pouvez maintenant accéder à votre <a href="account.php">espace utilisateur</a> pour voir vos films.</p>
        </div>
    <?php elseif ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php else: ?>
        <div class="checkout-container">
            <div class="order-summary">
                <h2>Récapitulatif de votre commande</h2>

                <?php if (empty($cartItems)): ?>
                    <p>Votre panier est vide.</p>
                    <a href="movies.php" class="btn">Parcourir les films</a>
                <?php else: ?>
                    <div class="movie-list">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="movie-item-checkout">
                                <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                                <div class="movie-details">
                                    <h3><?= htmlspecialchars($item['title']) ?></h3>
                                    <p class="price"><?= htmlspecialchars($item['price']) ?> €</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="total-container">
                        <h3>Total: <span class="total-price"><?= number_format($cartTotal, 2) ?> €</span></h3>
                    </div>

                    <form method="post" class="checkout-form">
                        <input type="hidden" name="confirm_order" value="1">
                        <button type="submit" class="btn checkout-btn">Confirmer la commande</button>
                    </form>

                    <a href="cart.php" class="back-to-cart">Retour au panier</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</main>
</body>

<footer>
    <p>2025 - Supinstream</p>
</footer>
</html>
