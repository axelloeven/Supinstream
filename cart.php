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
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<header>
    <div class="logo">
        <img src="images/logo.png" alt="Logo Supinstream">
        <h1>supinstream</h1>
    </div>
    <div class="menu">
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="movies.php">Films</a></li>
                <li><a href="categories.php">Categories</a></li>
                <div class="searchbar">
                    <input type="text" placeholder="Search...">
                    <button type="submit">Search</button>
                </div>
            </ul>
        </nav>
    </div>
    <div class="cart">
        <a href="cart.php"><img src="cart.png" alt="Image cart"> </a>
    </div>
    <div class="user">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="account.php"><img src="user.png" alt="Image user"> </a>
        <?php else: ?>
            <a href="connexion.php"><img src="user.png" alt="Image user"> </a>
        <?php endif; ?>
    </div>
</header>
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

