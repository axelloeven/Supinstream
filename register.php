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
    <title>supinstream</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<header>
    <div class="logo">
        <img src="images/logo.png" alt="Logo Supinstream">
        <h1>supinstream</h1>
    </div>
    <div class="menu">
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="movies.php">Films</a></li>
                <li><a href="categories.php">Categories</a></li>
                <div class="searchbar">
                    <input type="text" placeholder="Search...">
                    <button type="submit">Search</button>
                </div>
            </ul>
        </nav>
    </div>
    <div class="cart">
        <a href="cart.php"><img src="cart.png" alt="Image cart"> </a>
    </div>
    <div class="user">
        <a href="login.php"><img src="user.png" alt="Image user"> </a>
    </div>
</header>
<body>
<main class="container">
    <section class="register-form">
        <h1>Créer un compte</h1>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success-message">
                <?= htmlspecialchars($success) ?>
                <p><a href="login.php">Se connecter</a></p>
            </div>
        <?php else: ?>
            <form method="POST" action="register.php">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur*</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">Prénom</label>
                        <input type="text" id="first_name" name="first_name">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Nom</label>
                        <input type="text" id="last_name" name="last_name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe*</label>
                    <input type="password" id="password" name="password" required>
                    <small>Au moins 6 caractères</small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe*</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit" class="btn">S'inscrire</button>
            </form>

            <p class="login-link">Déjà un compte ? <a href="login.php">Se connecter</a></p>
        <?php endif; ?>
    </section>
</main>
</body>
<footer>
    <p>2025 - Supinstream</p>
</footer>
</html>
