<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/config.php';
require 'cartfunction.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['movie_id']) && isset($_POST['quantity'])) {
        $movie_id = $_POST['movie_id'];
        $quantity = (int)$_POST['quantity'];


        if ($quantity < 1) {
            $quantity = 1;
        }

        $result = addToCart($conn, $movie_id);

        if ($result['success']) {
            header('Location: cart.php?status=added');
            exit();
        } else {
            header('Location: connexion.php?id=' . $movie_id . '&error=' . urlencode($result['message']));
            exit();
        }
    } else {
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>

<?php
