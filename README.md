# GameShift
# GameShift — Lancement en local (XAMPP)

Ce projet est une application web PHP avec :
- un **Front Office** (`Front_Office/`)
- un **Back Office** (`Back_Office/`)
- une base de données MySQL fournie dans `Base de donnée/GameShift.sql`

---

## Prérequis

- **XAMPP** (Apache + MySQL + phpMyAdmin)
- Un navigateur (Chrome / Firefox / Edge)
- Windows (chemins donnés pour Windows, adaptable sur Linux/Mac)

---

## Installation du projet

1. Dézipper le projet.
2. Copier le dossier du projet dans le dossier `htdocs` de XAMPP :

   Exemple :
C:\xampp\htdocs\GameShift\

## Démarrer les services XAMPP

Ouvrir **XAMPP Control Panel** puis cliquer sur :
- **Start** sur `Apache`
- **Start** sur `MySQL`

Dans le navigateur mettez cette URL:
- `http://localhost/gameShift/Front_Office/ ` Pour accéder au Front-office

## Important : URL = nom du dossier dans `htdocs` (y compris pour le lien de vérification)

L’URL d’accès dépend directement du nom du dossier présent dans :

`C:\xampp\htdocs\`

Exemple : si le projet est dans :
`C:\xampp\htdocs\GameShift\`

Alors les URLs sont :
- Front : `http://localhost/GameShift/Front_Office/`
- Back : `http://localhost/GameShift/Back_Office/`

⚠️ Si tu tapes un autre chemin (ex: `http://localhost/jeushift/...`) ça ne marchera **pas**, sauf si :
- un dossier `C:\xampp\htdocs\jeushift\` existe, **ou**
- tu as configuré un **Alias / VirtualHost** Apache qui pointe `jeushift` vers le dossier du projet.

### Lien de vérification email (register.php)
Dans `Front_Office/register.php`, le lien envoyé par email contient une URL du type :
`http://localhost/GameShift/Front_Office/verifier_email.php?email=...&token=...`

➡️ La partie **`GameShift`** doit être **exactement le nom du dossier** du projet dans `htdocs`.
Exemples :
- Dossier : `C:\xampp\htdocs\GameShift\` → URL avec `/GameShift/`
- Dossier : `C:\xampp\htdocs\GameShift-main\` → URL avec `/GameShift-main/`

Sinon, le lien mènera à une erreur **404 Not Found**.

### Majuscules / minuscules (casse)
- Sur **Windows (XAMPP)** : `GameShift` et `gameshift` fonctionnent généralement pareil (pas sensible à la casse).
- Sur **Linux (serveur)** : la casse compte, donc il faut utiliser exactement le même nom (`GameShift` ≠ `gameshift`).
