# Concept du site

## Membre du groupe :

- Randy Mahfoud
- Louis Peruzzi

# Cahier des charges / Site des skateparks vaudois

## 1. Contexte et objectifs

Le site est une application web qui répertorie les skateparks du canton de Vaud, les affiche sur une carte et permet à la communauté d'en ajouter de nouveaux, validés par un administrateur avant publication.

Objectifs :

- Centraliser des infos fiables par skatepark : adresse, taille, modules, photos, compte Instagram.
- Trouver vite un skatepark proche grâce à la géolocalisation, à la carte et aux filtres.
- Faire vivre la base par les utilisateurs, avec une modération par un admin.
- Voir quels parks sont appréciés grâce aux likes.
- Proposer le site en français et en anglais.

## 2. Utilisateurs et rôles

Trois profils, chacun avec des droits cumulatifs : un visiteur consulte, un utilisateur connecté contribue, un admin modère.

| Rôle | Pages accessibles | Actions possibles |
| --- | --- | --- |
| Visiteur (non connecté) | 1, 2, 3, 4 | Consulter les skateparks, rechercher, filtrer, créer un compte, se connecter |
| Utilisateur connecté | 1 à 8 | Tout ce que fait le visiteur, plus liker un park, gérer son profil, ajouter un skatepark, suivre le statut de ses ajouts |
| Admin | 1 à 8, plus la section admin du profil | Tout ce que fait l'utilisateur, plus valider ou refuser les skateparks proposés |

Un accès à une page privée sans être connecté redirige vers la connexion. La section admin du profil n'est visible et accessible que pour les admins.

## 3. Fonctionnalités générales

- **Bilingue FR / EN** : sélecteur FR | EN dans le footer, tous les textes de l'interface traduits.
- **Comptes** : création de compte (page 4, avec le lien « Déjà un compte ? Se connecter »), connexion, déconnexion (bouton en bas de la page profil).
- **Rôles** : utilisateur et admin, contrôlés côté serveur.
- **Géolocalisation** : sur l'accueil, les 5 skateparks les plus proches de la position de l'utilisateur s'affichent avant toute saisie dans la recherche.
- **Recherche** : barre de recherche avec bouton sur l'accueil et sur la page carte. La page carte a un bouton « Filtres » qui filtre selon les caractéristiques des parks (taille, modules, etc.).
- **Carte interactive** : les skateparks sont placés sur une carte, un clic mène à la fiche.
- **Likes et favoris** : un like par utilisateur et par park, il sert de favori. Le compteur de likes (par exemple 463) s'affiche sur les cartes et sur la fiche.
- **Ajout avec validation** : un park ajouté est « En attente » jusqu'à la décision d'un admin, puis « Validée » (ou refusée). Le statut est visible page 7.
- **Pages légales** : le footer renvoie vers les mentions légales et la politique de confidentialité, et vers les conditions générales.
- **Sécurité des mots de passe** : jamais stockés en clair.

## 4. Description des pages

### Éléments communs

- **Header** : menu déroulant à gauche (Map, Favoris, Ajouter un skatepark, Profil), logo au centre, icône de connexion à droite (photo de profil une fois connecté) qui mène à la connexion ou au profil.
- **Footer** : sélecteur FR | EN, liens vers les mentions légales et la politique de confidentialité, liens vers les conditions générales, logo.
- **Cartes de skatepark** (accueil, page 2, section admin) : photo, nom, adresse et compteur de likes.

### 1. Accueil (public)

Image d'accueil, barre de recherche avec bouton, puis liste des 5 skateparks les plus proches de l'utilisateur (visible avant toute saisie).

### 2. Map et liste (public)

Carte interactive, barre de recherche avec bouton « Filtres » (taille, modules, etc.), liste des skateparks sous forme de cartes (photo, nom, adresse, likes).

### 3. Fiche d'un skatepark (public)

Page générée en PHP selon le park choisi. Grande image avec le nom, bouton like et compteur, site web et compte Instagram, bloc Détails (taille S à XL, extérieur ou intérieur, espace repos), bloc Modules (rampe, rails, box, curb, flat) avec photos, adresse et carte.

### 4. Création de compte (public)

Nom, prénom, mail ou téléphone, NPA, mot de passe, photo de profil (optionnelle), bouton de création, lien « Déjà un compte ? Se connecter ».

### 5. Profil (privé)

Photo, nom, prénom et infos de l'utilisateur, bande « Skateparks favoris », bande « Skateparks ajoutés », bouton « Se déconnecter ».

### 6. Skateparks likés (privé)

Grille à deux colonnes des parks likés (photo et nom).

### 7. Skateparks ajoutés (privé)

Bouton « Ajouter un skatepark » et grille des parks ajoutés, chacun avec un badge « En attente » ou « Validée ».

### 8. Ajout d'un skatepark (privé)

Formulaire : nom, site web ou Insta, taille (S, M, L, XL), modules à cocher (rampe, box, flat, quarter, rail, curb, bowl, autre), photos, adresse. Bouton « Envoyer pour validation ».

### Section admin du profil (admin)

Section affichée en plus sur la page profil, réservée aux admins : titre « Administration », compteur « À valider (3) », une carte par park en attente avec les boutons Accepter et Refuser.

## 5. Exigences techniques et sécurité

- **Stack** : HTML, CSS, JavaScript, PHP, base de données SQL (MySQL ou MariaDB).
- **Carte et géolocalisation** : Leaflet avec OpenStreetMap et API de géolocalisation du navigateur. Les distances sont calculées en SQL. L'adresse du formulaire est convertie en coordonnées pour placer le park sur la carte.
- **Sécurité** : mots de passe hachés (`password_hash()`), requêtes préparées (PDO), données affichées échappées, jeton CSRF sur les formulaires, rôle vérifié côté serveur.
- **Photos** : type et taille des fichiers contrôlés avant l'envoi.
- **Hébergement et données** : HTTPS obligatoire, données personnelles limitées au nécessaire (LPD).

## 6. Exigences non fonctionnelles

- **Responsive** : conçu d'abord pour mobile.
- **Performance** : images compressées.
- **Accessibilité et SEO** : textes alternatifs, contrastes suffisants, URL et titre propres par skatepark.
- **Compatibilité** : navigateurs récents, sur ordinateur et mobile.


## Maquette 
- https://www.figma.com/design/UOPrGiwj2R67KdeuJkf9fZ/Site-de-skate?node-id=0-1&t=fy3b0EjjVLYUzlwb-1


# HEIG-VD ProgServ2 Course PHP Template

Ce modèle de projet est conçu pour les étudiant.es du cours
[_"Programmation Serveur 2 (ProgServ2)"_](https://github.com/heig-vd-progserv-course/heig-vd-progserv2-course)
à la [HEIG-VD](https://heig-vd.ch).

Il fournit une structure de base pour les projets PHP avec les éléments suivants
:

- Un serveur [Apache](https://httpd.apache.org/) avec
  [PHP 8.5](https://www.php.net/) et les extensions nécessaires pour se
  connecter à une base de données [MariaDB](https://mariadb.org/).
- Une base de données [MariaDB](https://mariadb.org/) préconfigurée avec un
  utilisateur et un mot de passe par défaut. Dans vos scripts PHP, utilisez le
  nom d'hôte `mariadb` et les identifiants définis dans le fichier
  `compose.yaml`.
- Une interface web [phpMyAdmin](https://www.phpmyadmin.net/) pour gérer la base
  de données MariaDB en utilisant les mêmes identifiants que ceux définis dans
  le fichier `compose.yaml`.
- Un serveur SMTP [Mailpit](https://mailpit.axllent.org/) pour tester l'envoi
  d'e-mails depuis votre application PHP.
- Des configurations recommandées pour l'éditeur de code
  [Visual Studio Code](https://code.visualstudio.com/), y compris des extensions
  utiles pour le développement PHP et la gestion de bases de données
  ([PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client),
  [Prettier](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode),
  [SQLite Viewer](https://marketplace.visualstudio.com/items?itemName=qwtel.sqlite-viewer)).

Tous ses éléments sont configurés pour fonctionner avec
[Docker Compose](https://docs.docker.com/compose/), ce qui permet de créer un
environnement de développement isolé et reproductible.

N'hésitez pas à personnaliser ce modèle et ce document pour ajouter des
instructions spécifiques à votre projet ou des détails supplémentaires sur la
configuration et l'utilisation du projet.

## Utiliser ce modèle pour votre projet

1. Cliquez sur le bouton "Use this template" (Utiliser ce modèle) sur la page
   GitHub de ce dépôt.
2. Donnez un nom à votre nouveau dépôt et configurez les options selon vos
   préférences.
3. Invitez les membres de votre équipe à collaborer sur le projet en leur
   donnant accès au dépôt (si applicable).
4. Chaque membre de l'équipe doit cloner le nouveau dépôt sur sa machine locale
   pour commencer à travailler sur le projet.
5. Utilisez le workflow GitHub étudié en cours pour gérer les branches, les
   commits et les pull requests afin de collaborer efficacement sur le projet.

## Structure du projet

- `.devcontainer/`: Contient la configuration pour le développement dans un
  conteneur Debian (Trixie) avec Visual Studio Code.
- `.vscode/`: Contient les paramètres recommandés pour Visual Studio Code.
- `.gitignore`: Fichier de configuration pour Git, spécifiant les fichiers et
  dossiers à ignorer.
- `compose.yaml`: Fichier de configuration pour Docker Compose, définissant les
  services nécessaires pour le projet, avec :
  - [Apache](https://httpd.apache.org/) : Serveur web pour exécuter les fichiers
    PHP.
  - [MariaDB](https://mariadb.org/) : Base de données relationnelle.
  - [phpMyAdmin](https://www.phpmyadmin.net/) : Interface web pour gérer la base
    de données MariaDB.
  - [Mailpit](https://mailpit.axllent.org/) : Serveur SMTP pour tester l'envoi
    d'e-mails.
- `index.php`: Fichier PHP principal du projet.
- `script.sql`: Fichier SQL pour créer la table `my_table` dans la base de
  données.
- `README.md`: Ce fichier de documentation.

## Ouvrir le projet localement

> [!NOTE]
>
> Il est important d'ouvrir le dossier du projet directement et non un dossier
> parent.
>
> Pensez à bien ouvrir le dossier du projet lui-même (celui qui contient ce
> fichier README.md) et non un dossier parent. Ouvrir un dossier parent peut
> entraîner des problèmes de configuration et de fonctionnement de Visual Studio
> Code.

1. Clonez ce dépôt sur votre machine locale.
2. Ouvrez ce dossier dans Visual Studio Code.

## Ouvrir le projet dans un conteneur de développement

Si vous avez l'extension
[Dev Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers)
installée, Visual Studio Code vous proposera d'ouvrir le projet dans un
conteneur Docker.

Acceptez cette proposition pour bénéficier d'un environnement de développement
préconfiguré.

Si aucune notification n'apparaît, vous pouvez ouvrir manuellement le conteneur
en utilisant la commande _"Dev Containers: Reopen in Container"_ dans la palette
de commandes (<kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>P</kbd> sur Windows/Linux ou
<kbd>Cmd</kbd>+<kbd>Shift</kbd>+<kbd>P</kbd> sur macOS).

## Démarrer les services Docker

Pour démarrer les services Docker nécessaires à développer des applications PHP,
ouvrez un terminal intégré dans Visual Studio Code et exécutez la commande
suivante :

```bash
# Démarre tous les services définis dans le fichier compose.yaml
docker compose up
```

Ceci va démarrer les services suivants dans des conteneurs Docker :

- Apache (port 8080) : Serveur web pour exécuter les fichiers PHP.
- MariaDB (port 3306) : Base de données relationnelle.
- phpMyAdmin (port 9090) : Interface web pour gérer la base de données MariaDB.
- Mailpit (ports 1025 et 8025) : Serveur SMTP pour tester l'envoi d'e-mails.

## Se connecter à la base de données MariaDB avec phpMyAdmin

La configuration Docker Compose inclut également phpMyAdmin, un outil web pour
gérer les bases de données MariaDB.

Pour accéder à phpMyAdmin, ouvrez votre navigateur et rendez-vous à l'adresse
suivante : <http://localhost:9090>.

Vous pourrez alors vous connecter à la base de données en utilisant les
identifiants décrits dans le fichier `compose.yaml` (par défaut, l'utilisateur
est `username` et le mot de passe est `password`).

## Exécuter des requêtes SQL sur la base de données MariaDB

Une fois connecté à la base de données MariaDB via phpMyAdmin, vous pouvez
exécuter des requêtes SQL pour créer des tables, insérer des données ou
effectuer d'autres opérations sur la base de données.

1. Ouvrez/créez un fichier SQL dans Visual Studio Code (par exemple,
   `script.sql`).
2. Écrivez votre requête SQL dans ce fichier (par exemple, une requête pour
   créer une table ou insérer des données).
3. Dans l'onglet "SQL" de phpMyAdmin, vous pouvez copier et coller votre requête
   SQL depuis le fichier `script.sql` et l'exécuter pour appliquer les
   modifications à la base de données.

## Voir les données de la table `my_table`

Une fois le ou les scripts SQL exécutés, vous pouvez vérifier que les données
ont été correctement insérées dans la table `my_table` dans le menu latéral
gauche de phpMyAdmin. Cliquez sur le nom de la base de données, puis sur le nom
de la table pour voir les données.

## Exécuter vos scripts PHP

La configuration Docker Compose inclut un serveur web Apache avec PHP, ce qui
vous permet d'exécuter vos scripts PHP directement dans le conteneur.

Le serveur sera accessible à l'adresse <http://localhost:8080> dans votre
navigateur.

La liste des fichiers PHP disponibles sera affichée, et vous pourrez cliquer sur
un fichier pour l'exécuter.

Les scripts PHP peuvent se connecter à la base de données MariaDB en utilisant
le nom d'hôte `mariadb` et les identifiants définis dans le fichier
`compose.yaml`.

En accédant à l'adresse <http://localhost:8080/public/index.php>, vous pourrez
exécuter le script PHP principal du projet.

La page d'accueil de démonstration affiche un message de bienvenue et utilise la
base de données MariaDB pour afficher les données de la table `my_table`.

## Visualiser les e-mails envoyés par votre application PHP

Le serveur SMTP Mailpit est inclus dans la configuration Docker Compose pour
vous permettre de tester l'envoi d'e-mails depuis votre application PHP.

Pour accéder à l'interface web de Mailpit, ouvrez votre navigateur et
rendez-vous à l'adresse suivante : <http://localhost:8025>.

Vous y verrez la liste des e-mails envoyés par votre application PHP, ainsi que
leur contenu et les détails de l'envoi.

Si vous fermez/redémarrez Mailpit, les e-mails précédemment envoyés seront
perdus, car ils ne sont pas stockés de manière persistante.

## Arrêter les services Docker

Si vous avez exécuté la commande `docker compose up` pour démarrer les services
Docker, vous pouvez les arrêter avec le raccourci clavier
<kbd>Ctrl</kbd>+<kbd>C</kbd> dans le terminal où la commande a été exécutée.
Cela arrêtera les services et libérera les ressources utilisées par les
conteneurs Docker.

Sinon, vous pouvez également arrêter les services Docker en ouvrant un terminal
intégré dans Visual Studio Code et en exécutant la commande suivante :

```bash
# Arrête tous les services définis dans le fichier compose.yaml
docker compose down
```

Lorsque vous fermez Visual Studio Code, les conteneurs Docker seront
automatiquement arrêtés. Dès que vous rouvrez Visual Studio Code et que vous
exécutez à nouveau la commande `docker compose up`, les services Docker seront
redémarrés.
