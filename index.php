<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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
    <link href="src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="src/script.js" defer></script>
</head>

<?php require_once('header.php'); ?>
<body>
<div class="landing texrt bg-[#181A1B]">
    <div class="flex justify-center items-center w-full py-12">
        <h1 class="text-7xl font-bold text-center text-[#E8E6E3]">Bienvenue sur Supinstream</h1>
    </div>
</div>
<section class="bg-[#181A1B]">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-[#E8E6E3]">Les films à ne pas manquer</h2>

        <div class="mt-6 flex flex-wrap justify-between">
            <div class="w-1/4 px-2 mb-8">
                <div class="group relative">
                    <a href="infomovie.php?id=<?php echo htmlspecialchars($movies[0]['movie_id']); ?>">
                        <div class="overflow-hidden rounded-md">
                            <img src="<?php echo $movies[0]['image_path']; ?>" alt="<?php echo htmlspecialchars($movies[0]['title']); ?>"
                                 class="w-full h-110 object-cover group-hover:opacity-75 text-[#E8E6E3]">
                        </div>
                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-[#E8E6E3]">
                                <?php echo htmlspecialchars($movies[0]['title']); ?>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500"><?php echo htmlspecialchars($movies[0]['release_year']); ?></p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Film 2 -->
            <div class="w-1/4 px-2 mb-8">
                <div class="group relative">
                    <a href="infomovie.php?id=<?php echo htmlspecialchars($movies[2]['movie_id']); ?>">
                        <div class="overflow-hidden rounded-md">
                            <img src="<?php echo $movies[2]['image_path']; ?>" alt="<?php echo htmlspecialchars($movies[2]['title']); ?>"
                                 class="w-full h-110 object-cover group-hover:opacity-75">
                        </div>
                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-[#E8E6E3]">
                                <?php echo htmlspecialchars($movies[2]['title']); ?>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500"><?php echo htmlspecialchars($movies[2]['release_year']); ?></p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="w-1/4 px-2 mb-8">
                <div class="group relative">
                    <a href="infomovie.php?id=<?php echo htmlspecialchars($movies[3]['movie_id']); ?>">
                        <div class="overflow-hidden rounded-md">
                            <img src="<?php echo $movies[3]['image_path']; ?>" alt="<?php echo htmlspecialchars($movies[3]['title']); ?>"
                                 class="w-full h-110 object-cover group-hover:opacity-75">
                        </div>
                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-[#E8E6E3]">
                                <?php echo htmlspecialchars($movies[3]['title']); ?>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500"><?php echo htmlspecialchars($movies[3]['release_year']); ?></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="w-1/4 px-2 mb-8">
                <div class="group relative">
                    <a href="infomovie.php?id=<?php echo htmlspecialchars($movies[4]['movie_id']); ?>">
                        <div class="overflow-hidden rounded-md">
                            <img src="<?php echo $movies[4]['image_path']; ?>" alt="<?php echo htmlspecialchars($movies[4]['title']); ?>"
                                 class="w-full h-110 object-cover group-hover:opacity-75">
                        </div>
                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-[#E8E6E3]">
                                <?php echo htmlspecialchars($movies[4]['title']); ?>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500"><?php echo htmlspecialchars($movies[4]['release_year']); ?></p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
<?php require_once('footer.php'); ?>
</html>
