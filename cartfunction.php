<?php
function addToCart($conn, $movie_id) {
    if (!isset($_SESSION['user_id'])) {
        return ['success' => false, 'message' => 'Please log in first'];
    }
    $user_id = $_SESSION['user_id'];

        $query = "INSERT INTO cart (user_id, movie_id) VALUES ('$user_id', '$movie_id')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $user_id);
        $stmt->bind_param('i', $movie_id);
        $stmt->execute();

        return ['success' => true, 'message' => 'Added to cart'];
}

function removeFromCart($conn, $movie_id) {
    if (!isset($_SESSION['user_id'])) {
        return ['success' => false, 'message' => 'Please log in first'];
    }
    $user_id = $_SESSION['user_id'];
    $query = "DELETE FROM cart WHERE user_id = '$user_id' AND movie_id = '$movie_id'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
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

function getCartItems($conn, $movie_id) {
    if (!isset($_SESSION['user_id'])) {
        return [];

    }
    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM cart WHERE user_id = '$user_id' AND movie_id = '$movie_id'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function getTotalPrice($conn, $movie_id) {
    $total = 0;
    foreach ($cartItems as $item) {
        $total += $item['quantity'] * $item['price'];
    }
    return $total;
}

function clearCart($conn, $movie_id) {
    if (!isset($_SESSION['user_id'])) {
        return ['success' => false, 'message' => 'Please log in first'];
    }
    $user_id = $_SESSION['user_id'];
    $query = "DELETE FROM cart WHERE user_id = '$user_id' AND movie_id = '$movie_id'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return ['success' => true, 'message' => 'Removed from cart'];
}

?>

