<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require "config/config.php";

function getMovieDetails($conn, $movieID) {
    $query = "SELECT movie_id, title, release_year, genre, image_path FROM movie WHERE movie_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$movieID]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_GET['id'])) {
    $movieID = $_GET['id'];
    $movie = getMovieDetails($conn, $movieID);

    if ($movie) {
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['title']); ?></title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="src/script.js" defer></script>
</head>

<?php require_once('header.php'); ?>
    <div class="movietitle">
        <h1>Détails du film :</h1>
        <h1><?php echo htmlspecialchars($movie['title']); ?></h1>
    </div>
<div class="movieinfo">
    <img src="<?php echo htmlspecialchars($movie['image_path']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
    <p><strong>Année de sortie:</strong> <?php echo htmlspecialchars($movie['release_year']); ?></p>
    <p><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
</div>
<div class="addtocart">
    <form method="post" action="addtocart.php">
        <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
        <input type="hidden" name="quantity" value="1">
        <button type="submit">Add to cart</button>
    </form>
</div>
</main>
<footer><p>2025 - Supinstream</p></footer>
</body>
</html>
        <?php
    } else {
        echo "Film non trouvé.";
    }
} else {
    echo "ID de film non spécifié.";
}
?>
