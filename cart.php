<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/config.php';
require 'cartfunction.php';

if (!isset($_SESSION['user_id'])) {
    header('location: connexion.php?redirect=cart.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update':
                if (isset($_POST['cart_id']) && isset($_POST['quantity'])) {
                    updateCart($conn, $_POST['cart_id'], $_POST['quantity']);
                }
                break;
            case 'remove':
                if (isset($_POST['cart_id'])) {
                    removeFromCart($conn, $_POST['cart_id']);
                }
                break;
            case 'clear':
                clearCart($conn);
                break;
        }

    }
}

$cartItems = getCartItems($conn, $conn);
$cartTotal = getTotalPrice($cartItems, $conn);
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
<main>
    <body>
    <h1>Votre panier</h1>
    <div class="noproduct">
    <?php if (empty($cartItems)): ?>
        <p>Vous n'avez pas encore d'articles à votre panier</p>>
        <a href="index.php">Venez les découvrir ici !</a>
        </div>
    <?php else: ?>
        <div class="products">
            <?php foreach ($cartItems as $item): ?>
            <div class="item">
                <img src="<?php echo htmlspecialchars($item['image_path'])?>" alt="Image cart">
                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                <p><?php echo htmlspecialchars($item['price']); ?></p>
            </div>
            <form method="post" class="remove-from-cart">
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                <button type="submit" class="remove-from-cart">Remove</button>
            </form>
        </div>
    <?php endforeach; ?>

    <div class="total">
        <h3>Total: €<?php echo number_format($cartTotal, 2); ?></h3>
    </div>

    <div class="clear-cart">
        <form method="post" class="cleat-cart">
            <input type="hidden" name="action" value="clear">
            <button type="submit" class="cleat-cart">CLEAR</button>
        </form>
        <a href="checkout.php" class="cleat-cart">CHECKOUT</a>
    </div>
    <?php endif; ?>
    </body>
</main>
<footer><p>2025 - Supinstream</p></footer>

