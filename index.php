<?php
require 'config/config.php';
require 'config/get_movies.php';
$movies = getMoviesFromDatabase($conn, 5);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>supinstream</title>
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
            <a href="login.php"><img src="user.png" alt="Image user"> </a>
        </div>
</header>

<body>
<div class="landing texrt">
    <h1>Bienvenue sur Supinstream</h1>
    <p>Votre plateforme de streaming préférée</p>
    <a href="movies.php" class="button">Voir les films</a>
</div>
<div class="Featured movies">
    <h2>Les films à ne pas manquer</h2>
    <div class="movies-list">
        <div class="movie-item"><a href="movie.php?id=<?php echo $movies[0]['movie_id']; ?>">
            <img src="<?php echo $movies[0]['image_path']; ?>" alt="<?php echo $movies[0]['title']; ?>">
            <h3><?php echo htmlspecialchars($movies[0]['title']); ?></h3>
            <p><?php echo htmlspecialchars($movies[0]['release_year']); ?></p>
            </a>
        </div>
        <div class="movie-item"><a href="movie.php?id=<?php echo $movies[2]['movie_id']; ?>">
            <img src="<?php echo $movies[2]['image_path']; ?>" alt="<?php echo $movies[2]['title']; ?>">
            <h3><?php echo htmlspecialchars($movies[2]['title']); ?></h3>
            <p><?php echo htmlspecialchars($movies[2]['release_year']); ?></p>
            </a>
        </div>
        <div class="movie-item"><a href="movie.php?id=<?php echo $movies[3]['movie_id']; ?>">
            <img src="<?php echo $movies[3]['image_path']; ?>" alt="<?php echo $movies[3]['title']; ?>">
            <h3><?php echo htmlspecialchars($movies[3]['title']); ?></h3>
            <p><?php echo htmlspecialchars($movies[3]['release_year']); ?></p>
            </a>
        </div>
        <div class="movie-item"><a href="movie.php?id=<?php echo $movies[4]['movie_id']; ?>">
            <img src="<?php echo $movies[4]['image_path']; ?>" alt="<?php echo $movies[4]['title']; ?>">
            <h3><?php echo htmlspecialchars($movies[4]['title']); ?></h3>
            <p><?php echo htmlspecialchars($movies[4]['release_year']); ?></p>
            </a>
        </div>
    </div>
</div>
<div class="footer">
    <p>&copy; 2023 Supinstream. Tous droits réservés.</p>
    <div class="social-media">
        <a href="#"><img src="facebook.png" alt="Facebook"></a>
        <a href="#"><img src="twitter.png" alt="Twitter"></a>
        <a href="#"><img src="instagram.png" alt="Instagram"></a>
    </div>
</div>
</body>
</html>
