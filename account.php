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
    <link href="src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="src/script.js" defer></script>
</head>
<body class="bg-black text-white flex flex-col min-h-screen">
<?php require_once('header.php'); ?>

<main class="flex-grow container mx-auto px-4 py-8">
    <div class="bg-gray-900 rounded-lg shadow-xl overflow-hidden">
        <div class="bg-violet-600 py-4">
            <h1 class="text-2xl font-bold text-center text-white">Mon Compte</h1>
        </div>

        <div class="md:flex">
            <!-- Sidebar -->
            <div class="md:w-1/4 bg-gray-800 p-6">
                <div class="user-info mb-6">
                    <p class="mb-2"><span class="font-bold text-violet-300">Nom d'utilisateur:</span> <?= htmlspecialchars($user['username'] ?? '') ?></p>
                    <p class="mb-2"><span class="font-bold text-violet-300">Email:</span> <?= htmlspecialchars($user['email'] ?? '') ?></p>
                    <?php if (!empty($user['firstname']) || !empty($user['lastname'])): ?>
                        <p><span class="font-bold text-violet-300">Nom:</span> <?= htmlspecialchars($user['firstname'] ?? '') ?> <?= htmlspecialchars($user['lastname'] ?? '') ?></p>
                    <?php endif; ?>
                </div>

                <div class="account-menu">
                    <ul class="space-y-2">
                        <li class="bg-violet-500 text-white rounded-md">
                            <a href="#films" class="block px-4 py-2 hover:bg-violet-600 rounded-md transition duration-150">Mes Films</a>
                        </li>
                        <li>
                            <a href="logout.php" class="block px-4 py-2 text-white hover:bg-gray-700 rounded-md transition duration-150">Déconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="md:w-3/4 p-6">
                <section id="films" class="user-movies">
                    <h2 class="text-xl font-bold mb-6 text-violet-400">Mes Films</h2>

                    <?php if (empty($userMovies)): ?>
                        <div class="text-center py-8 bg-gray-800 rounded-lg">
                            <p class="text-gray-400 mb-4">Vous n'avez pas encore de films dans votre bibliothèque.</p>
                            <a href="movies.php" class="bg-violet-500 text-white py-2 px-6 rounded-md hover:bg-violet-600 transition duration-150 inline-block">Parcourir les films</a>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php foreach ($userMovies as $movie): ?>
                                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                                    <a href="infomovie.php?id=<?= htmlspecialchars($movie['movie_id']) ?>">
                                        <img src="<?= htmlspecialchars($movie['image_path']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="w-full h-110 object-cover">
                                        <div class="p-4">
                                            <h3 class="font-medium text-lg mb-1"><?= htmlspecialchars($movie['title']) ?></h3>
                                            <p class="text-gray-400 text-sm"><?= htmlspecialchars($movie['release_year']) ?></p>
                                            <p class="text-violet-300 text-sm mb-4"><?= htmlspecialchars($movie['genre']) ?></p>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
</main>

<?php require_once('footer.php'); ?>
</body>
</html>