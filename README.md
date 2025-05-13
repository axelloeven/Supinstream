# Internet Movies DataBase & Co

Ce projet est une plateforme web permettant aux utilisateurs de consulter, rechercher et acheter des films en ligne. Développé avec HTML, CSS, PHP et une base de données SQL, ce site remplace l'ancien système papier pour offrir une expérience digitale complète.

## 🎬 Aperçu du Projet

Notre plateforme permet aux utilisateurs de:

- Parcourir un catalogue de films
- Rechercher des films par titre ou réalisateur
- Consulter les détails des films (acteurs, réalisateurs)
- Ajouter des films à un panier d'achat
- Créer un compte et gérer leur profil
- Consulter l'historique de leurs achats
- Changer leur mot de passe

## 🚀 Fonctionnalités

### Page d'Accueil (`index.php`)

- Textes de présentation
- Affichage des films avec titre, prix, bouton d'ajout au panier
- Barre de recherche pour trouver des films par titre ou réalisateur

### Système de Recherche (`search.php`)

- Accessible depuis l'en-tête
- Recherche par titre ou réalisateur
- Affichage des résultats de manière claire et organisée

### Pages de Catégories (`categories.php`)

- Catégories de films disponibles
- Chaque catégorie affiche les films correspondants
- Navigation intuitive entre les catégories

### Page de Détails du Film (`infomovie.php`)

- Image du film
- Titre
- Réalisateur (avec lien vers tous les films de ce réalisateur)
- Acteurs
- Prix
- Bouton "Ajouter au panier"

### Page Panier (`cart.php`)

- Liste des films ajoutés
- Bouton de suppression (pour un film spécifique ou vider le panier)
- Montant total
- Panier persistant entre les sessions
- Fonction de passage à la caisse (`checkout.php`)

### Pages d'Authentification

- Inscription (`register.php`)
- Connexion (`connexion.php`)
- Déconnexion (`logout.php`)

### Page Profil (`account.php`)

- Liste des films achetés
- Fonction de changement de mot de passe (`changepassword.php`)
- Bouton de déconnexion

## 💻 Technologies Utilisées

- **Frontend**: HTML5, CSS3
- **Backend**: PHP 8.0+
- **Base de données**: MySQL
- **Responsive Design**: Adaptation à tous les types d'appareils

## 🛠️ Installation

1. Clonez ce dépôt

   ```bash
   git clone https://github.com/votre-utilisateur/PHP.git
   cd PHP
   ```

2. Configurez votre serveur web (Apache/XAMPP) pour pointer vers le dossier du projet

3. Importez la base de données depuis le fichier SQL fourni

4. Configurez les paramètres de connexion à la base de données dans `config/config.php`

## 📁 Structure du Projet

```
├── config/           # Fichiers de configuration
│   ├── config.php    # Configuration de la base de données
│   ├── get_movies.php # Récupération des films
│   └── import_movies.php # Import de films
├── images/           # Images utilisées dans le projet
├── src/              # Ressources CSS et JS
├── *.php             # Fichiers PHP principaux (index, login, etc.)
└── README.md         # Documentation du projet
```

## 🛒 Fonctionnalités du Panier

Le panier utilise les fichiers suivants:

- `addtocart.php` - Pour ajouter des films au panier
- `cart.php` - Pour afficher et gérer le panier
- `cartfunction.php` - Fonctions utilitaires pour le panier
- `checkout.php` - Pour finaliser l'achat

## 👤 Gestion des Utilisateurs

La gestion des utilisateurs comprend:

- `register.php` - Inscription des nouveaux utilisateurs
- `connexion.php` - Connexion des utilisateurs existants
- `user_fonction.php` - Fonctions liées aux utilisateurs
- `account.php` - Gestion du profil utilisateur
- `changepassword.php` - Modification du mot de passe
- `logout.php` - Déconnexion

## 👥 Contributeurs

- [Votre Nom]
- [Nom du Collaborateur]

## 📝 Licence

Ce projet est sous licence MIT
