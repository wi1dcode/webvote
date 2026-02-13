# WebVote

Application MVC en PHP permettant de publier des pétitions et de les signer.

## Fonctionnalités

- Inscription / Connexion
- Profil utilisateur ( changement MDP / Avatar )
- Recherche, filtres
- Pétitions (CRUD par l'auteur)
- Commentaires
- Signature d'une pétition
- Administration (utilisateurs, visibilité des pétitions)

## Architecture

- `Core/` : Router, Controller, Model, Session, Request, Autoload
- `App/Controller/`
- `App/Model/` 
- `App/View/`
- `public/uploads/` : fichiers uploadés

## Installation

1. Copier le dossier du projet
2. Importer le SQL : `SQL/webvote.sql`
3. Vérifier la configuration BDD : `Core/config.xml`

## Compte admin pour démonstration

- Email : `admin@mail.fr`
- Mot de passe : `administrator`

## Notes

<img width="1500" height="770" alt="image" src="https://github.com/user-attachments/assets/e8339066-054b-480b-8520-fafa9ada5b71" />
