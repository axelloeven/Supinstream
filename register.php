<?php
session_start();
require_once 'config/config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
        $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';


        if (strlen($username) < 3) {
            $error = 'Le nom d\'utilisateur doit contenir au moins 3 caractères';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email invalide';
        } elseif (strlen($password) < 6) {
            $error = 'Le mot de passe doit contenir au moins 6 caractères';
        } elseif ($password !== $confirm_password) {
            $error = 'Les mots de passe ne correspondent pas';
        } else {
            try {
                $query = "SELECT COUNT(*) FROM USER WHERE email = :email OR username = :username";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':username', $username);
                $stmt->execute();

                if ($stmt->fetchColumn() > 0) {
                    $error = 'Cet email ou nom d\'utilisateur existe déjà';
                } else {
                    // Hasher le mot de passe
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insérer le nouvel utilisateur
                    $query = "INSERT INTO USER (username, email, password, firstname, lastname) 
                              VALUES (:username, :email, :password, :firstname, :lastname)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $hashed_password);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);

                    if ($stmt->execute()) {
                        $success = 'Compte créé avec succès! Vous pouvez maintenant vous connecter.';
                    } else {
                        $error = 'Erreur lors de la création du compte';
                    }
                }
            } catch (PDOException $e) {
                $error = 'Erreur de base de données: ' . $e->getMessage();
            }
        }
    } else {
        $error = 'Veuillez remplir tous les champs obligatoires';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Supinstream</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="src/script.js" defer></script>
</head>
<body class="bg-black text-white flex flex-col min-h-screen">
<?php require_once('header.php'); ?>

<div class="flex-grow flex items-center justify-center px-6 py-12">
    <div class="bg-gray-900 rounded-lg shadow-xl w-full max-w-md overflow-hidden">
        <div class="bg-violet-600 py-4">
            <h1 class="text-2xl font-bold text-center text-white">Créer un compte</h1>
        </div>

        <div class="p-8">
            <?php if ($error): ?>
                <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-300 px-4 py-3 rounded mb-6">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-500 bg-opacity-20 border border-green-500 text-green-300 px-4 py-3 rounded mb-6">
                    <?= htmlspecialchars($success) ?>
                    <p class="mt-2"><a href="connexion.php" class="text-green-200 underline">Se connecter</a></p>
                </div>
            <?php else: ?>
                <form method="POST" action="register.php" class="space-y-4">
                    <div>
                        <label for="username" class="block text-violet-300 mb-2 font-medium">Nom d'utilisateur*</label>
                        <input type="text" id="username" name="username" required
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 text-white">
                    </div>

                    <div>
                        <label for="email" class="block text-violet-300 mb-2 font-medium">Email*</label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 text-white">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="firstname" class="block text-violet-300 mb-2 font-medium">Prénom</label>
                            <input type="text" id="firstname" name="firstname"
                                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 text-white">
                        </div>

                        <div>
                            <label for="lastname" class="block text-violet-300 mb-2 font-medium">Nom</label>
                            <input type="text" id="lastname" name="lastname"
                                   class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 text-white">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-violet-300 mb-2 font-medium">Mot de passe*</label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 text-white">
                        <small class="text-gray-400 mt-1 block">Au moins 6 caractères</small>
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-violet-300 mb-2 font-medium">Confirmer le mot de passe*</label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                               class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500 text-white">
                    </div>

                    <button type="submit"
                            class="w-full bg-violet-500 text-white py-3 px-4 rounded-md hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition duration-150 mt-2">
                        S'inscrire
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-400">Déjà un compte?
                        <a href="connexion.php" class="text-violet-400 hover:text-violet-300 font-medium">Se connecter</a>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
</body>
</html>