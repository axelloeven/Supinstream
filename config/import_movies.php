<?php
require_once 'config.php';

$api_key = "f8dceef7";

$imdb_ids = [
    'tt30795948', // Un p'tit truc en plus
    'tt29547746', // Le Comte de Monte-Cristo
    'tt22022452', // Vice-Versa 2
    'tt13622970', // Vaiana 2
    'tt27490099', // L'Amour ouf
    'tt7510222',  // Moi, moche et méchant 4
    'tt15239678', // Dune - Deuxième partie
    'tt6263850',  // Deadpool & Wolverine
    'tt9218128',  // Gladiator II
    'tt11389872'  // La Planète des Singes : Le Nouveau Royaume
];

echo "Connexion à la base de données réussie!\n";

function getMovieData($imdb_id, $api_key)
{
    $url = "http://www.omdbapi.com/?i=$imdb_id&apikey=$api_key&plot=full";
    $response = file_get_contents($url);

    if ($response === false) {
        echo "Erreur lors de la récupération des données pour $imdb_id\n";
        return null;
    }

    $data = json_decode($response, true);

    if (isset($data['Error']) || $data['Response'] === 'False') {
        echo "Erreur API pour $imdb_id: " . ($data['Error'] ?? "Réponse non valide") . "\n";
        return null;
    }

    return $data;
}

function insertDirector($conn, $director_name)
{
    $name_parts = explode(' ', $director_name, 2);
    $first_name = $name_parts[0];
    $last_name = isset($name_parts[1]) ? $name_parts[1] : '';

    $stmt = $conn->prepare("SELECT director_id FROM director WHERE first_name = ? AND last_name = ?");
    $stmt->execute([$first_name, $last_name]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['director_id'];
    }

    $stmt = $conn->prepare("INSERT INTO director (first_name, last_name) VALUES (?, ?)");
    $stmt->execute([$first_name, $last_name]);

    return $conn->lastInsertId();
}

function insertActor($conn, $actor_name)
{
    $name_parts = explode(' ', $actor_name, 2);
    $first_name = $name_parts[0];
    $last_name = isset($name_parts[1]) ? $name_parts[1] : '';

    $stmt = $conn->prepare("SELECT actor_id FROM actor WHERE first_name = ? AND last_name = ?");
    $stmt->execute([$first_name, $last_name]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['actor_id'];
    }

    $stmt = $conn->prepare("INSERT INTO actor (first_name, last_name) VALUES (?, ?)");
    $stmt->execute([$first_name, $last_name]);

    return $conn->lastInsertId();
}

function insertType($conn, $type_name)
{
    $stmt = $conn->prepare("SELECT type_id FROM type WHERE type_name = ?");
    $stmt->execute([$type_name]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['type_id'];
    }

    $stmt = $conn->prepare("INSERT INTO type (type_name) VALUES (?)");
    $stmt->execute([$type_name]);

    return $conn->lastInsertId();
}

function importMovie($conn, $movie_data)
{
    $conn->beginTransaction();

    try {
        $stmt = $conn->prepare("INSERT INTO movie (title, release_year, genre, image_path) VALUES (?, ?, ?, ?)");
        $release_year = intval(substr($movie_data['Released'], -4)) ?: intval($movie_data['Year']);
        $genre = $movie_data['Genre'];
        $poster = $movie_data['Poster'] !== "N/A" ? $movie_data['Poster'] : "default_poster.jpg";

        $stmt->execute([$movie_data['Title'], $release_year, $genre, $poster]);
        $movie_id = $conn->lastInsertId();

        if (isset($movie_data['Director']) && $movie_data['Director'] !== "N/A") {
            $directors = explode(', ', $movie_data['Director']);
            foreach ($directors as $director_name) {
                $director_id = insertDirector($conn, $director_name);

                $stmt = $conn->prepare("INSERT INTO movie_director (movie_id, director_id) VALUES (?, ?)");
                $stmt->execute([$movie_id, $director_id]);
            }
        }

        if (isset($movie_data['Actors']) && $movie_data['Actors'] !== "N/A") {
            $actors = explode(', ', $movie_data['Actors']);
            foreach ($actors as $actor_name) {
                $actor_id = insertActor($conn, $actor_name);

                $stmt = $conn->prepare("INSERT INTO movie_actor (movie_id, actor_id) VALUES (?, ?)");
                $stmt->execute([$movie_id, $actor_id]);
            }
        }

        if (isset($movie_data['Genre']) && $movie_data['Genre'] !== "N/A") {
            $genres = explode(', ', $movie_data['Genre']);
            foreach ($genres as $genre_name) {
                $type_id = insertType($conn, $genre_name);

                $stmt = $conn->prepare("INSERT INTO movie_type (movie_id, type_id) VALUES (?, ?)");
                $stmt->execute([$movie_id, $type_id]);
            }
        }

        $conn->commit();
        echo "Film '{$movie_data['Title']}' importé avec succès!\n";
        return true;

    } catch (Exception $e) {
        $conn->rollBack();
        echo "Erreur lors de l'importation du film '{$movie_data['Title']}': " . $e->getMessage() . "\n";
        return false;
    }
}

$successful_imports = 0;
$failed_imports = 0;

foreach ($imdb_ids as $imdb_id) {
    echo "Traitement du film $imdb_id...\n";

    $movie_data = getMovieData($imdb_id, $api_key);
    if ($movie_data) {
        $result = importMovie($conn, $movie_data);
        if ($result) {
            $successful_imports++;
        } else {
            $failed_imports++;
        }
    } else {
        $failed_imports++;
    }

    sleep(1);
}

echo "\nProcessus d'importation terminé!\n";
echo "Films importés avec succès: $successful_imports\n";
echo "Échecs d'importation: $failed_imports\n";
?>