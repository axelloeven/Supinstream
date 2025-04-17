<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/config.php';
require 'user_fonction.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = "Tous les champs sont obligatoires";
    } elseif ($new_password !== $confirm_password) {
        $error = "Les nouveaux mots de passe ne correspondent pas";
    } elseif (strlen($new_password) < 8) {
        $error = "Le nouveau mot de passe doit contenir au moins 8 caractères";
    } else {
        $result = changeUserPassword($conn, $user_id, $current_password, $new_password);

        if ($result['success']) {
            $message = "Votre mot de passe a été modifié avec succès";
        } else {
            $error = $result['message'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer le mot de passe - supinstream</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<?php require_once('header.php'); ?>
<body class="bg-black">
<main class="flex-grow container mx-auto px-4 py-6">
    <div class="max-w-md mx-auto bg-gray-800 rounded-lg shadow-md p-6">
        <h1 class="text-white text-2xl font-bold mb-6 text-center">Changer votre mot de passe</h1>

        <?php if (!empty($message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-4">
                <label for="current_password" class="block text-white mb-1">Mot de passe actuel</label>
                <input type="password" id="current_password" name="current_password"
                       class="w-full bg-gray-700 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="new_password" class="block text-white mb-1">Nouveau mot de passe</label>
                <input type="password" id="new_password" name="new_password"
                       class="w-full bg-gray-700 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label for="confirm_password" class="block text-white mb-1">Confirmer le nouveau mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password"
                       class="w-full bg-gray-700 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Changer le mot de passe
            </button>
        </form>
    </div>
</main>
</body>
<?php require_once('footer.php'); ?>
</html>