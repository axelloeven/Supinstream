<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
function addToCart($conn, $movie_id) {
    if (!isset($_SESSION['user_id'])) {
        return ['success' => false, 'message' => 'Please log in first'];
    }
    $user_id = $_SESSION['user_id'];

    try {
        $query = "INSERT INTO cart (user_id, movie_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id, $movie_id]);

        return ['success' => true, 'message' => 'Added to cart'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}

function removeFromCart($conn, $cart_id) {
    if (!isset($_SESSION['user_id'])) {
        return ['success' => false, 'message' => 'Please log in first'];
    }
    $user_id = $_SESSION['user_id'];
    $query = "DELETE FROM cart WHERE cart_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$cart_id, $user_id]);
    return ['success' => true, 'message' => 'Removed from cart'];
}

function updateCart($conn, $movie_id) {
    if (!isset($_SESSION['user_id'])) {
        return ['success' => false, 'message' => 'Please log in first'];
    }
    $user_id = $_SESSION['user_id'];
    $query = "UPDATE cart SET quantity = '1' WHERE user_id = '$user_id' AND movie_id = '$movie_id'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return ['success' => true, 'message' => 'Updated to cart'];
    }
    else {
        return ['success' => false, 'message' => 'Update failed'];
    }
}

function getCartItems($conn) {
    if (!isset($_SESSION['user_id'])) {
        return [];
    }
    $user_id = $_SESSION['user_id'];

    $query = "SELECT c.cart_id, c.movie_id, m.title, m.image_path, m.price 
              FROM cart c 
              JOIN movie m ON c.movie_id = m.movie_id 
              WHERE c.user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalPrice($cartItem) {
    $total = 0;
    foreach ($cartItem as $item) {
        $total += $item['price'];
    }
    return $total;
}

function clearCart($conn) {
    if (!isset($_SESSION['user_id'])) {
        return ['success' => false, 'message' => 'Please log in first'];
    }
    $user_id = $_SESSION['user_id'];
    $query = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);

    return ['success' => true, 'message' => 'Cart cleared'];
}

?>

