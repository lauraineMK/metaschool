# MetaSchool

**MetaSchool** is a web application for managing courses, sections, modules, and lessons, developed with Laravel. It allows teachers to create and manage courses and students to view available courses.

---

## Sommaire

- [Introduction](#introduction)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Organisation des cours](#organisation-des-cours)
- [Contributions](#contributions)
- [Documentation](#documentation)
- [Licence](#licence)


## Introduction

MetaSchool est une application web permettant aux enseignants de créer et organiser des cours, et aux étudiants de les explorer et suivre leur progression.


## Installation

### Prérequis

- PHP >= 7.4
- Composer

### Cloner le dépôt

```bash
git clone https://github.com/yourusername/metaschool.git

# MetaSchool LMS

## Installation
1. Clonez le repo
2. Installez les dépendances PHP (`composer install`)
3. Installez les dépendances JS (`npm install`)
4. Configurez le fichier `.env`
5. Lancez les migrations (`php artisan migrate`)
6. Compilez les assets (`npm run dev`)

## Fonctionnalités principales
- Gestion des cours, sections, modules, leçons
- Ajout de vidéos et documents (YouTube, PDF, images)
- Quiz par leçon
- Suivi de progression
- Interface enseignant et élève
- Design moderne et compact (voir page détail cours)

## Structure
- `app/Models` : Eloquent models
- `app/Http/Controllers` : Contrôleurs
- `resources/views` : Blade templates
- `routes/web.php` : Routes principales
- `database/migrations` : Migrations
- `database/seeders` : Seeders

## Changements récents
- Correction des erreurs de syntaxe Blade
- Refonte du design de la page détail cours (moderne, compact, responsive)
- Suppression des doublons header/footer (utilisation du layout principal)
- Mise à jour de la documentation

## TODO
- Finaliser la logique quiz/module
- Ajouter des tests unitaires
- Compléter la documentation (voir docs/)

## Changelog
Consultez `docs/CHANGELOG.md` pour l'historique des modifications.
### Lancer le serveur

```bash
php artisan serve
```

Accédez à l'application sur <http://localhost:8000>.


## Configuration

Les principales routes sont définies dans `routes/web.php`.
Le middleware des rôles est dans `app/Http/Middleware/RoleMiddleware.php`.
L'authentification est personnalisable dans `app/Http/Controllers/Auth`.


## Utilisation

- Créer un cours : <http://localhost:8000/teachers/courses/create>
- Voir les cours : <http://localhost:8000/teachers/courses>
- Modifier un cours : <http://localhost:8000/teachers/courses/{id}/edit>
- Supprimer un cours : bouton supprimer sur la liste des cours


## Organisation des cours

Pour ordonner les leçons, modules et sections dans la base de données, utilisez les commandes Artisan suivantes :

- Mettre à jour l'ordre des leçons :
  ```bash
  php artisan lessons:update-order
  ```
- Mettre à jour l'ordre des modules :
  ```bash
  php artisan modules:update-order
  ```
- Mettre à jour l'ordre des sections :
  ```bash
  php artisan sections:update-order
  ```


## Contributions

Les contributions sont les bienvenues !
Merci de :
1. Forker le dépôt
2. Créer une branche (`git checkout -b feature/ma-feature`)
3. Apporter vos modifications
4. Documenter la correction dans le dossier `docs/` et dans `CHANGELOG.md`
5. Commit (`git commit -am 'Ajout de la feature'`)
6. Push (`git push origin feature/ma-feature`)
7. Ouvrir une Pull Request

Avant de soumettre :
- Vérifiez que les tests unitaires passent
- Vérifiez que les pages d’édition (cours, leçon) sont fonctionnelles et stylées
- Documentez ou corrigez les bugs connus


## Documentation

Tous les détails techniques et bugs sont dans le dossier `docs/` :
- COURSE_MANAGEMENT.md : gestion des cours, sections, modules
- QUIZ_MANAGEMENT.md : gestion des quiz et bugs SQL
- ERROR_MANAGEMENT.md : erreurs récentes et suggestions de correction


## Licence

Ce projet est sous licence MIT.
