<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php?redirect=account.php');
    exit();
}

try {
    $stmt = $conn->prepare("SELECT username, email, firstname, lastname FROM USER WHERE ID = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("
        SELECT m.movie_id, m.title, m.image_path, m.release_year, m.genre, um.purchase_date 
        FROM user_movies um
        JOIN movie m ON um.movie_id = m.movie_id
        WHERE um.user_id = ?
        ORDER BY um.purchase_date DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $userMovies = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = "Erreur: " . $e->getMessage();
}
?>

    <!DOCTYPE html>
    <html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte - Supinstream</title>
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

<body>
<main class="container">
    <div class="account-container">
        <div class="account-sidebar">
            <h2>Mon Compte</h2>
            <div class="user-info">
                <p><strong>Nom d'utilisateur:</strong> <?= htmlspecialchars($user['username'] ?? '') ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? '') ?></p>
                <?php if (!empty($user['firstname']) || !empty($user['lastname'])): ?>
                    <p><strong>Nom:</strong> <?= htmlspecialchars($user['firstname'] ?? '') ?> <?= htmlspecialchars($user['lastname'] ?? '') ?></p>
                <?php endif; ?>
            </div>

            <div class="account-menu">
                <ul>
                    <li class="active"><a href="#films">Mes Films</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>
            </div>
        </div>

        <div class="account-content">
            <section id="films" class="user-movies">
                <h2>Mes Films</h2>

                <?php if (empty($userMovies)): ?>
                    <div class="no-movies">
                        <p>Vous n'avez pas encore de films dans votre bibliothèque.</p>
                        <a href="movies.php" class="btn">Parcourir les films</a>
                    </div>
                <?php else: ?>
                    <div class="movies-grid">
                        <?php foreach ($userMovies as $movie): ?>
                            <div class="movie-card">
                                <a href="infomovie.php?id=<?= htmlspecialchars($movie['movie_id']) ?>">
                                    <img src="<?= htmlspecialchars($movie['image_path']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>">
                                    <div class="movie-info">
                                        <h3><?= htmlspecialchars($movie['title']) ?></h3>
                                        <p class="movie-year"><?= htmlspecialchars($movie['release_year']) ?></p>
                                        <p class="movie-genre"><?= htmlspecialchars($movie['genre']) ?></p>
                                    </div>
                                </a>
                                <a href="play.php?id=<?= htmlspecialchars($movie['movie_id']) ?>" class="play-btn">Regarder</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
</main>
</body>

<footer>
    <p>2025 - Supinstream</p>
</footer>
    </html>
