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
    <title>supinstream</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="src/script.js" defer></script>
</head>

<?php require_once('header.php'); ?>
<body>
<main class="container">
    <section class="login-form">
        <h1>Connexion</h1>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="connexion.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn">Se connecter</button>
        </form>

        <p class="register-link">Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
    </section>
</main>
</body>
<footer>
    <p>&copy; 2023 Supinstream. Tous droits réservés.</p>
</footer>