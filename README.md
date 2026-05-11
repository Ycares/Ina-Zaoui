# Ina Zaoui - Site Symfony

Application Symfony 7.2 pour le portfolio d'une photographe, avec front office public et back office d'administration.

## Pre-requis

- PHP 8.2+
- Composer 2+
- PostgreSQL 16+ (ou version compatible DBAL)
- Extensions PHP : `ext-ctype`, `ext-iconv`
- Optionnel : Symfony CLI (`symfony`)
- Pour la couverture de tests : Xdebug (mode `coverage`)

## Installation

1. Cloner le depot puis installer les dependances :
   - `composer install`
2. Configurer l'environnement :
   - copier `.env` vers `.env.local` puis adapter `DATABASE_URL`
   - verifier `APP_SECRET`
3. Creer la base puis appliquer les migrations :
   - `php bin/console doctrine:database:create --if-not-exists`
   - `php bin/console doctrine:migrations:migrate`
4. Charger les donnees/media du projet si necessaire :
   - importer le dump SQL fourni
   - placer les medias dans `public/uploads/`

## Lancer le projet

- Avec Symfony CLI : `symfony server:start`
- Alternative PHP natif : `php -S 127.0.0.1:8000 -t public`

## Utilisation

Pages front principales :
- `/` : accueil
- `/guests` : liste des invites
- `/guest/{id}` : fiche invite (404 si invite bloque ou admin)
- `/portfolio` et `/portfolio/{id}` : galerie et filtrage par album
- `/about` : page de presentation

Pages admin :
- `/login` : connexion
- `/admin` : tableau de bord
- `/admin/media` : gestion des medias
- `/admin/album` : gestion des albums (admin uniquement)
- `/admin/guests` : gestion des invites (admin uniquement)

