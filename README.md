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

Copiez le fichier .env.example et renommez-le en .env.
Configurez les paramètres de la base de données et d'autres configurations dans le fichier .env.
dans le terminal :

cp .env.example .env

4. Générez la clé d'application Laravel :

dans le terminal :
 
php artisan key:generate

5. Exécutez les migrations :

dans le terminal :

php artisan migrate

6. Lancez le serveur de développement :

7. dans le terminal :

php artisan serve