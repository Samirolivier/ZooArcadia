# ZooArcadia - Gestion des Habitats et Animaux

Bienvenue sur le projet de gestion des habitats et des animaux du Zoo Arcadia. Ce projet permet de consulter les habitats du zoo ainsi que les détails sur les animaux qui y résident, tout en incluant des informations telles que leur état de santé, leur alimentation, leur grammage et l'heure de leur dernière alimentation. Le projet inclut également la gestion des services proposés par le zoo et des avis (reviews) des visiteurs grâce à l'intégration de MongoDB.

## Fonctionnalités

- **Liste des habitats** : Chaque habitat contient une description et affiche les animaux présents dans celui-ci.
- **Détails des animaux** : En cliquant sur un animal, une modale affiche des informations détaillées comme l'image, le nom, l'état de santé, l'alimentation et le grammage.
- **Gestion des services** : Une collection MongoDB services permet de stocker et de récupérer les services offerts par le zoo.
- **Gestion des avis** : Une collection MongoDB reviews permet de gérer les avis des visiteurs du zoo.
  
## Technologies Utilisées

- **Front-end** :
  - HTML, CSS
  - JavaScript pour la gestion des modales et des requêtes AJAX
  - Effets de survol pour une meilleure interactivité
    
- **Back-end** :
  - PHP : pour la génération dynamique des pages et la gestion des requêtes
  - PDO (PHP Data Objects) : pour la gestion des interactions avec la base de données MySQL
  - MongoDB : Pour gérer des collections supplémentaires (services et reviews).
    
- **Base de données** :
  - MySQL pour stocker les informations sur les animaux, les habitats, et les logs d'alimentation.
  - MongoDB : Pour les services et les avis des visiteurs.

## Prérequis

- PHP >= 8.1.100
- MySQL
- MongoDG
- Serveur web Apache 2.4.54

## Installation

1. Clonez ce dépôt sur votre machine locale :

    ```bash
    git clone https://github.com/Samirolivier/Arcadia-Zoo.git
    ```

2. Naviguez dans le dossier du projet :

    ```bash
    cd Arcadia-Zoo
    ```

3. Importez la base de données `zooarcadia.sql` fournie dans le dossier `config/`. Vous pouvez le faire via phpMyAdmin.

    ```bash
    mysql -u root -p zooarcadia < config/zooarcadia.sql
    ```

4. Configurez les paramètres de connexion à la base de données dans le fichier `config/config.php` :

    ```php
    <?php
    $host = 'localhost';
    $dbname = 'zooarcadia';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base données : " . $e->getMessage();
    }
    ?>

5. Assurez-vous que votre serveur web pointe vers le dossier du projet.

## Utilisation

1. Une fois que vous avez configuré la base de données et démarré le serveur, ouvrez un navigateur et accédez à la page d'accueil du projet :

    ```bash
    http://localhost/arcadia/index.php
    ```

2. Depuis la page d'accueil, vous pouvez naviguer vers les sections **Habitats**, **Services**, **Contact**, etc.

3. Sur la page des habitats, vous pouvez voir la liste des habitats. Cliquez sur un habitat pour voir les animaux présents. cliquez sur un animal pout voir les détails de cet animal dans une modale interactive.

4. La modale vous montrera :
   - L'image de l'animal
   - Son état de santé
   - Son type de nourriture
   - Son grammage
   - Le nombre de vues

5. Chaque fois que vous ouvrez la modale d'un animal, le nombre de vues est mis à jour dans la base de données.

## licence
MIT

## Voici quelques exemples de la requête SQL utilisée:

```php
- Pour mettre à jour le nombre de vues d'un animal à chaque fois que ses détails sont consultés :

$sql_update = "UPDATE animals SET views = views + 1 WHERE id = ?";
$stmt_update = $pdo->prepare($sql_update);
$stmt_update->execute([$id]);


- Pour inserer des messages dans la base de données

$stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
$stmt->execute([$name, $email, $message]);

- Pour éviter les injections SQL

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();
