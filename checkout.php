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
    <title>Finaliser votre commande - Supinstream</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="src/script.js" defer></script>
</head>
<body class="bg-black text-white flex flex-col min-h-screen">
<?php require_once('header.php'); ?>

<main class="flex-grow container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-center mb-8 text-violet-400">Finalisez votre commande</h1>

    <?php if ($success): ?>
        <div class="bg-green-500 bg-opacity-20 border border-green-500 text-green-300 px-6 py-6 rounded-lg max-w-lg mx-auto text-center">
            <h2 class="text-2xl font-bold mb-4 text-green-200">Commande confirmée !</h2>
            <p class="mb-2">Vos films ont été ajoutés à votre espace personnel.</p>
            <p class="mb-4">Vous pouvez maintenant accéder à votre <a href="account.php" class="text-green-200 underline hover:text-green-100">espace utilisateur</a> pour voir vos films.</p>
        </div>
    <?php elseif ($error): ?>
        <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-300 px-6 py-4 rounded-lg max-w-lg mx-auto mb-6">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php else: ?>
        <div class="bg-gray-900 rounded-lg shadow-xl max-w-2xl mx-auto overflow-hidden">
            <div class="bg-violet-600 py-4">
                <h2 class="text-xl font-bold text-center text-white">Récapitulatif de votre commande</h2>
            </div>

            <div class="p-6">
                <?php if (empty($cartItems)): ?>
                    <div class="text-center py-8">
                        <p class="text-gray-400 mb-6">Votre panier est vide.</p>
                        <a href="movies.php" class="bg-violet-500 text-white py-2 px-6 rounded-md hover:bg-violet-600 transition duration-150 inline-block">Parcourir les films</a>
                    </div>
                <?php else: ?>
                    <div class="space-y-4 mb-8">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="flex items-center bg-gray-800 rounded-lg overflow-hidden">
                                <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="h-24 w-auto object-cover">
                                <div class="px-4 py-3 flex-grow">
                                    <h3 class="font-medium text-white"><?= htmlspecialchars($item['title']) ?></h3>
                                    <p class="text-violet-300 font-medium"><?= htmlspecialchars($item['price']) ?> €</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="border-t border-gray-700 pt-4 mb-6">
                        <div class="flex justify-between items-center text-lg font-bold">
                            <h3>Total:</h3>
                            <span class="text-violet-300"><?= number_format($cartTotal, 2) ?> €</span>
                        </div>
                    </div>

                    <form method="post" class="mb-4">
                        <input type="hidden" name="confirm_order" value="1">
                        <button type="submit" class="w-full bg-violet-500 text-white py-3 px-4 rounded-md hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition duration-150">
                            Confirmer la commande
                        </button>
                    </form>

                    <div class="text-center">
                        <a href="cart.php" class="text-violet-400 hover:text-violet-300 font-medium">Retour au panier</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</main>
<?php require_once('footer.php'); ?>
</body>
</html>
