<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error = ' ';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        try {
            $query = "SELECT ID, username, email, password FROM USER  WHERE email = :email";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['ID'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                header('Location: index.php');
                exit();
            } else {
                $error = 'Email ou mot de passe incorrect';
            }
        } catch (PDOException $e) {
            $error = 'Erreur de connexion: ' . $e->getMessage();
        }
    } else {
        $error = 'Veuillez remplir tous les champs';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Supinstream</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="src/script.js" defer></script>
</head>
<body class="bg-black text-white flex flex-col min-h-screen">
<?php require_once('header.php'); ?>

<div class="flex-grow flex items-center justify-center px-6 py-12">
    <div class="bg-gray-900 rounded-lg shadow-xl w-full max-w-md overflow-hidden">
        <div class="bg-violet-600 py-4">
            <h1 class="text-2xl font-bold text-center text-white">Connexion</h1>
        </div>

        <div class="p-8">
            <?php if ($error && $error != ' '): ?>
                <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-300 px-4 py-3 rounded mb-6">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="connexion.php" class="space-y-6">
                <div>
                    <label for="email" class="block text-violet-300 mb-2 font-medium">Email</label>
                    <input type="email" id="email" name="email" required
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 text-white">
                </div>

                <div>
                    <label for="password" class="block text-violet-300 mb-2 font-medium">Mot de passe</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 text-white">
                </div>

                <button type="submit"
                        class="w-full bg-violet-500 text-white py-3 px-4 rounded-md hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition duration-150">
                    Se connecter
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-400">Pas encore de compte?
                    <a href="register.php" class="text-violet-400 hover:text-violet-300 font-medium">Créer un compte</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
</body>
</html>