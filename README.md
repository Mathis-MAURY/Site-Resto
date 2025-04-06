# AP 2SIO 2024 - Limayrac
## MAURY Mathis, MIRBEAU Ethan, FRESQUET Pierre, FACCIN Sylvain 

### Description du projet
Bienvenue sur le dépôt du site **Ma Fée, restaurant fictif** imaginé pour la session 2023 du cours d'AP à Limayrac.

Ce site est entièrement réalisé en PHP, HTML/CSS et JS, sans framework additionnel.

| Lien|
|---|
| [Trello (**répartition des tâches et trace des tâches effectuées**)](https://trello.com/b/D2itpRZd/ap-restauration)  |  
| [Google Drive **(avec les lotissements)**](https://drive.google.com/drive/u/4/folders/1IGTkcjUtVRBLAa1_kO6avVsXxrzBvLm-)  |  
| [Documentation Technique API **(structures json, schéma url etc...)**](https://drive.google.com/file/d/1985-MeddnpbJsHRIGOItZkwVIaZ48aT2/view) |
| [Documentation Technique Application **(Lot 6)**](https://docs.google.com/document/d/1BUkqi0CJEnRU1HUZ1SOwu4FhXccUAPz2_KugGxujnPg/edit?tab=t.0) |
### Installation

**Prérequis**: 
- Vous devez disposer de PHP avec une version > 8.0
- Vous devez avoir une base de donnée mysql (la version importe peu tant qu'elle est récente)

**Étapes d'installation**
-
1. Clôner le dépôt dans le dossier de votre choix, tant qu'il est servit par Apache.
2. Dans le dossier sql-exports, un fichier **db_restoweb.sql** est présent, importez le sur mysql **SANS SELECTIONNER DE BASE DE DONNEE CAR UN CREATE DATABASE EST PRESENT**.
3. Une fois fait, modifiez les identifiants dans **assets/functions/ConnexionBDD.php**, et remplacez les par les accès à votre base de donnée.
4. Vous pouvez vous inscrire et vous amuser sur le site !
