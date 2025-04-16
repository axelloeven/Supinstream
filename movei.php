<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/config.php';
require 'config/get_movies.php';
$movies = getMoviesFromDatabase($conn, 50);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>supinstream</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="src/script.js" defer></script>
</head>

<?php require_once('header.php'); ?>
<body class="bg-black">
<main class="flex-grow container mx-auto px-4 py-6">
    <h1 class="text-white text-3xl font-bold mb-6 text-center">Tous les films</h1>


    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        <?php foreach ($movies as $movie) : ?>
            <div class="bg-[#35393B] rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="<?php echo htmlspecialchars($movie['image_path']); ?>"
                     alt="<?php echo htmlspecialchars($movie['title']); ?>"
                     class="w-full h-110 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-white"><?php echo htmlspecialchars($movie['title']); ?></h2>
                    <p class="text-gray-500"><?php echo htmlspecialchars($movie['release_year']); ?></p>
                    <p class="text-gray-500">
                        <?php echo htmlspecialchars($movie['genre'] ); ?>
                    </p>
                    <a href="infomovie.php?id=<?php echo $movie['movie_id']; ?>"
                       class="text-white hover:underline inline-block mt-2">Voir plus</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
<?php require_once('footer.php'); ?>
</html>