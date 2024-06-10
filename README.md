# Task Manager API

## Description
Une API RESTful pour la gestion de tâches, construite avec Laravel. Cette API inclut l'authentification des utilisateurs et la gestion des rôles.

## Prérequis
- PHP >= 7.4
- Composer
- Laravel 8.x
- MySQL ou tout autre SGBD compatible avec Laravel
- Git

## Installation

1. Clonez le dépôt GitHub :
   dans le terminal :
   git clone https://github.com/votre-nom-utilisateur/task-manager-api.git
   cd task-manager-api

2. Installez les dépendances :
composer install

3. Configurez l'environnement :

-Copiez le fichier .env.example et renommez-le en .env.
-Configurez les paramètres de la base de données et d'autres configurations dans le fichier .env.

dans le terminal :

cp .env.example .env

4. Générez la clé d'application Laravel :

dans le terminal :
 
php artisan key:generate

5. Exécutez les migrations :

dans le terminal :

php artisan migrate

6. Lancez le serveur de développement :

dans le terminal :

php artisan serve

# Utilisation
## Endpoints de l'API
1. Enregistrer un Utilisateur
Méthode : POST
URL : /api/register
Headers : Content-Type: application/json
Body : (JSON)
json
Copier le code
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
2. Connexion d'un Utilisateur
Méthode : POST
URL : /api/login
Headers : Content-Type: application/json
Body : (JSON)
json
Copier le code
{
  "email": "john@example.com",
  "password": "password123"
}
3. Créer une Tâche
Méthode : POST
URL : /api/tasks
Headers :
Content-Type: application/json
Authorization: Bearer {access_token}
Body : (JSON)
json
Copier le code
{
  "title": "New Task",
  "description": "Task description",
  "status": "pending",
  "due_date": "2024-12-31"
}
4. Récupérer Toutes les Tâches
Méthode : GET
URL : /api/tasks
Headers :
Authorization: Bearer {access_token}
5. Récupérer une Tâche Spécifique
Méthode : GET
URL : /api/tasks/{id}
Headers :
Authorization: Bearer {access_token}
6. Mettre à Jour une Tâche
Méthode : PUT
URL : /api/tasks/{id}
Headers :
Content-Type: application/json
Authorization: Bearer {access_token}
Body : (JSON)
json
Copier le code
{
  "title": "Updated Task",
  "description": "Updated description",
  "status": "completed",
  "due_date": "2024-12-31"
}
7. Supprimer une Tâche
Méthode : DELETE
URL : /api/tasks/{id}
Headers :
Authorization: Bearer {access_token}
8. Récupérer les Tâches Supprimées
Méthode : GET
URL : /api/deleted
Headers :
Authorization: Bearer {access_token}

# Postman
Vous pouvez trouver un fichier postman.json dans ce dépôt. Importez ce fichier dans Postman pour tester facilement les endpoints de l'API.
# Base de donnée
## Créer la Base de Données
créer une base de données nommée task-manager dans phpMyAdmin
## Exécuter les Migrations Artisan
Utilisez la commande suivante pour exécuter les migrations :

php artisan migrate