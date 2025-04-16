<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/config.php';
require 'config/get_movies.php';

$selected_genre = isset($_GET['genre']) && !empty($_GET['genre']) ? $_GET['genre'] : null;

$movies = getMoviesByGenre($conn, $selected_genre);

$genres = getAllGenres($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories - supinstream</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="src/script.js" defer></script>
</head>

<?php require_once('header.php'); ?>
<body class="bg-black">
<main class="flex-grow container mx-auto px-4 py-6">
    <h1 class="text-white text-3xl font-bold mb-6 text-center">Films : <?php echo $selected_genre ? htmlspecialchars($selected_genre) : 'Tous les genres'; ?></h1>
    >
    <form action="categories.php" method="GET" id="filterForm" class="mb-6">
        <div class="mb-4 max-w-xs mx-auto">
            <label for="genre" class="block text-white mb-2">Filtrer par genre:</label>
            <select name="genre" id="genre" class="w-full p-2 rounded-md bg-gray-800 text-white border border-gray-700" onchange="this.form.submit()">
                <option value="">Tous les genres</option>
                <?php foreach($genres as $genre) : ?>
                    <option value="<?php echo $genre['id']; ?>" <?php echo ($selected_genre == $genre['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($genre['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php if (empty($movies)) : ?>
            <div class="col-span-full text-center text-white text-xl">
                Aucun film trouvé dans cette catégorie.
            </div>
        <?php else : ?>
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
        <?php endif; ?>
    </div>
</main>
</body>
<?php require_once('footer.php'); ?>
</html>