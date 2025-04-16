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
    <title>Votre Panier - Supinstream</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="src/script.js" defer></script>
</head>
<body class="bg-black text-white flex flex-col min-h-screen">
<?php require_once('header.php'); ?>

<main class="flex-grow container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-center mb-8 text-violet-400">Votre panier</h1>

    <?php if (empty($cartItems)): ?>
        <div class="bg-gray-900 rounded-lg shadow-lg p-8 max-w-lg mx-auto text-center">
            <p class="text-gray-400 mb-4">Vous n'avez pas encore d'articles dans votre panier</p>
            <a href="index.php" class="bg-violet-500 text-white py-2 px-6 rounded-md hover:bg-violet-600 transition duration-150 inline-block">Venez les découvrir ici !</a>
        </div>
    <?php else: ?>
        <div class="bg-gray-900 rounded-lg shadow-xl max-w-4xl mx-auto overflow-hidden">
            <div class="bg-violet-600 py-4">
                <h2 class="text-xl font-bold text-center text-white">Articles dans votre panier</h2>
            </div>

            <div class="p-6">
                <div class="space-y-4 mb-8">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="flex flex-col sm:flex-row items-center bg-gray-800 rounded-lg overflow-hidden p-4 relative">
                            <img src="<?php echo htmlspecialchars($item['image_path'])?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="h-32 w-auto object-cover mb-4 sm:mb-0 sm:mr-4">

                            <div class="px-2 flex-grow text-center sm:text-left">
                                <h3 class="font-medium text-white text-lg mb-1"><?php echo htmlspecialchars($item['title']); ?></h3>
                                <p class="text-violet-300 font-medium"><?php echo htmlspecialchars($item['price']); ?> €</p>
                            </div>

                            <form method="post" class="mt-4 sm:mt-0">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition duration-150">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="border-t border-gray-700 pt-6 mb-6">
                    <div class="flex justify-between items-center text-lg font-bold">
                        <h3>Total:</h3>
                        <span class="text-violet-300"><?php echo number_format($cartTotal, 2); ?> €</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between gap-4">
                    <form method="post" class="w-full sm:w-auto">
                        <input type="hidden" name="action" value="clear">
                        <button type="submit" class="w-full bg-gray-700 text-white py-2 px-8 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-150">
                            VIDER LE PANIER
                        </button>
                    </form>

                    <a href="checkout.php" class="w-full sm:w-auto bg-violet-500 text-white py-2 px-8 rounded-md hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition duration-150 text-center">
                        PASSER COMMANDE
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<footer class="bg-gray-900 text-center py-4 text-gray-400 mt-auto">
    <p>&copy; 2025 - Supinstream</p>
</footer>
</body>
</html>