# Internet Movies DataBase & Co

Ce projet est une plateforme web permettant aux utilisateurs de consulter, rechercher et acheter des films en ligne. Développé avec HTML, CSS, PHP et une base de données SQL, ce site remplace l'ancien système papier pour offrir une expérience digitale complète.

## 🎬 Aperçu du Projet

Notre plateforme permet aux utilisateurs de:

- Parcourir un catalogue de films
- Rechercher des films par titre ou réalisateur
- Consulter les détails des films (acteurs, réalisateurs, synopsis)
- Ajouter des films à un panier d'achat
- Créer un compte et gérer leur profil
- Consulter l'historique de leurs achats

## 🚀 Fonctionnalités

### Page d'Accueil

- Textes de présentation
- Affichage des derniers films ajoutés (titre, prix, bouton d'ajout au panier)
- Barre de recherche pour trouver des films par titre ou réalisateur

### Système de Recherche

- Accessible depuis toutes les pages
- Recherche par titre ou réalisateur
- Affichage des résultats de manière claire et organisée

### Pages de Catégories

- Au moins deux catégories: Action et Drame
- Chaque catégorie contient une dizaine de films
- Navigation intuitive entre les catégories

### Page de Détails du Film

- Image du film
- Titre
- Réalisateur (avec lien vers tous les films de ce réalisateur)
- Acteurs
- Prix
- Bouton "Ajouter au panier"

### Page Panier

- Liste des films ajoutés
- Bouton de suppression (pour un film spécifique ou vider le panier)
- Montant total
- Panier persistant entre les sessions
- Accessible uniquement pour les utilisateurs connectés

### Pages d'Authentification

- Inscription
- Connexion
- Gestion des sessions

### Page Profil

- Liste des films achetés
- Formulaire de changement de mot de passe
- Bouton de déconnexion

## 💻 Technologies Utilisées

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 8.0+
- **Base de données**: MySQL
- **Responsive Design**: Adaptation à tous les types d'appareils

## 🛠️ Installation

1. Clonez ce dépôt

   ```bash
   git clone https://github.com/votre-utilisateur/imdb-project.git
   cd imdb-project
   ```

2. Configurez votre serveur web (Apache/Nginx) pour pointer vers le dossier du projet

3. Importez la base de données

   ```bash
   mysql -u username -p database_name < database/schema.sql
   ```

4. Configurez les paramètres de connexion à la base de données dans `config/database.php`

## 📁 Structure du Projet

```
├── assets/           # Ressources statiques (CSS, JS, images)
├── config/           # Fichiers de configuration
├── database/         # Scripts SQL et schéma de base de données
├── includes/         # Classes et fonctions PHP réutilisables
├── models/           # Modèles de données
├── public/           # Point d'entrée de l'application
├── templates/        # Templates HTML
└── README.md         # Documentation du projet
```

## 📋 Documentation

Une documentation complète est disponible dans le dossier `docs/`, incluant:

- Guide d'installation détaillé
- Structure de la base de données
- Guide d'utilisation
- Aspects techniques

## 👥 Contributeurs

- [Votre Nom](https://github.com/votre-utilisateur)
- [Nom du Collaborateur](https://github.com/collaborateur)

## 📝 Licence

Ce projet est sous licence MIT
