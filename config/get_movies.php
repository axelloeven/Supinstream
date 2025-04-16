<?php
require 'config.php';

function getMoviesFromDatabase($conn, $limit = 4)
{
    $limit = intval($limit);
    $query = "SELECT movie_id, title, image_path, release_year, genre FROM movie ORDER BY created_at DESC LIMIT :limit";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMoviesByGenre($conn, $genre = null) {
    $query = "SELECT movie_id, title, release_year, genre, image_path, price 
              FROM movie";

    $params = [];

    if ($genre) {
        $query .= " WHERE genre LIKE ?";
        $params[] = "%$genre%";
    }

    $query .= " ORDER BY release_year DESC";

    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllGenres($conn) {
    $query = "SELECT DISTINCT genre FROM movie ORDER BY genre ASC";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $genresAssoc = [];
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $genreList = explode(',', $row['genre']);
        foreach ($genreList as $g) {
            $g = trim($g);
            if (!empty($g)) {
                $genresAssoc[$g] = ['id' => $g, 'name' => $g];
            }
        }
    }

    $genres = array_values($genresAssoc);

    usort($genres, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });

    return $genres;
}