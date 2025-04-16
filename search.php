<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/config.php';

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$results = [];

if (!empty($query)) {
    try {
        $stmt = $conn->prepare("SELECT movie_id, title, release_year, genre, image_path FROM movie WHERE title LIKE :query");
        $stmt->execute([':query' => '%' . $query . '%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = 'Erreur de recherche : ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche - Supinstream</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="src/output.css" rel="stylesheet">
</head>
<body class="bg-[#181A1B] text-white min-h-screen flex flex-col">

<?php include('header.php'); ?>

<main class="flex-grow container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6 text-center">Résultats de recherche</h1>

    <?php if (!empty($query)): ?>
        <p class="text-center text-white mb-8">Résultats pour : <span class="font-semibold text-indigo-400"><?php echo htmlspecialchars($query); ?></span></p>
    <?php endif; ?>

    <?php if (!empty($results)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php foreach ($results as $movie): ?>
                <div class="bg-[#35393B] rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="<?php echo htmlspecialchars($movie['image_path']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="w-full h-60 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($movie['title']); ?></h2>
                        <p class="text-gray-500"><?php echo htmlspecialchars($movie['release_year']); ?> • <?php echo htmlspecialchars($movie['genre']); ?></p>
                        <a href="infomovie.php?id=<?php echo $movie['movie_id']; ?>" class="text-indigo-400 hover:underline inline-block mt-2">Voir plus</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-500">Aucun résultat trouvé.</p>
    <?php endif; ?>
</main>

<?php include('footer.php'); ?>

</body>
</html>
