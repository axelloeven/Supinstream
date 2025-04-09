<?php
require 'config.php';

function getMoviesFromDatabase($conn, $limit = 4) {
    $limit = intval($limit);
    $query = "SELECT movie_id, title, image_path, release_year FROM movie ORDER BY created_at DESC LIMIT $limit";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
