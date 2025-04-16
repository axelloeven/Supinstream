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
            <script src="src/script.js"></script>
        </head>
        <body class="bg-black text-white min-h-screen flex flex-col">
        <?php require_once('header.php'); ?>
        <main class="flex-grow container mx-auto px-4 py-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-violet-400 mb-2">Détails du film :</h1>
                <h1 class="text-4xl font-bold text-white"><?php echo htmlspecialchars($movie['title']); ?></h1>
            </div>

            <div class="max-w-4xl mx-auto bg-gray-900 rounded-lg shadow-lg overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-1/3">
                        <img class="w-full h-auto object-cover" src="<?php echo htmlspecialchars($movie['image_path']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                    </div>
                    <div class="md:w-2/3 p-6">
                        <div class="mb-6">
                            <p class="text-lg mb-2"><span class="font-bold text-violet-300">Année de sortie:</span> <?php echo htmlspecialchars($movie['release_year']); ?></p>
                            <p class="text-lg mb-4"><span class="font-bold text-violet-300">Genre:</span> <?php echo htmlspecialchars($movie['genre']); ?></p>
                        </div>

                        <form method="post" action="addtocart.php">
                            <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button class="bg-violet-500 hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 active:bg-violet-700 text-white font-medium py-3 px-6 rounded-md shadow-md transition duration-150 ease-in-out">
                                Ajouter au panier
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once('footer.php'); ?>
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
