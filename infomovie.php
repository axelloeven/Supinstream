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
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<header>
    <div class="logo">
        <img src="images/logo.png" alt="Logo Supinstream">
        <h1>supinstream</h1>
    </div>
    <div class="menu">
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="movies.php">Films</a></li>
                <li><a href="categories.php">Categories</a></li>
                <div class="searchbar">
                    <input type="text" placeholder="Search...">
                    <button type="submit">Search</button>
                </div>
            </ul>
        </nav>
    </div>
    <div class="cart">
        <a href="cart.php"><img src="cart.png" alt="Image cart"> </a>
    </div>
    <div class="user">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="account.php"><img src="user.png" alt="Image user"> </a>
        <?php else: ?>
            <a href="connexion.php"><img src="user.png" alt="Image user"> </a>
        <?php endif; ?>
    </div>
</header>
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
