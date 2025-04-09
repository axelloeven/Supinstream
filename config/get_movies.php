<?php
require 'config.php';

function getMoviesFromDatabase($conn, $limit = 4) {
    $query = "SELECT movie_id, title, image_path, release_year, genre FROM movie ORDER BY created_at DESC LIMIT ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$limit]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
