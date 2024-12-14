# ZooArcadia - Gestion des Habitats et Animaux

Bienvenue sur le projet de gestion des habitats et des animaux du Zoo Arcadia. Ce projet permet de consulter les habitats du zoo ainsi que les détails sur les animaux qui y résident, tout en incluant des informations telles que leur état de santé, leur alimentation et leur grammage, le nombre de vue des animaux etc. Le projet inclut également la gestion des services proposés par le zoo et des avis (reviews) des visiteurs grâce à l'intégration de MongoDB.

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
- MongoDB
- Serveur web Apache 2.4.54

## Installation

1. Clonez ce dépôt sur votre machine locale :

    ```bash
    git clone https://github.com/Samirolivier/ZooArcadia.git
    ```

2. Naviguez dans le dossier du projet :

    ```bash
    cd Arcadia-Zoo
    ```

3. Importez la base de données MySQL `zooarcadia 9 tables bon.sql` fournie dans le dossier `export/`. Vous pouvez le faire via phpMyAdmin ou en ligne de commande.

    ```bash
    mysql -u root -p zooarcadia < export/zooarcadia 9 tables bon.sql
    ```

4. Importez les fichiers pour la base de données NoSQL `zooarcadia.services.json` et `zooarcadia.reviews.json` fournie dans le dossier `export/`. Vous pouvez le faire via MongoDb Compass ou en ligne de commande.

    ```bash
    mongoimport --db zooarcadia --collection services --file export/zooarcadia.services.json --jsonArray
    mongoimport --db zooarcadia --collection reviews --file export/zooarcadia.reviews.json --jsonArray
    ```

5. Configurez les paramètres de connexion à la base de données MySQL dans le fichier `config/config_sql.php` :

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
        die("Erreur de connexion à la base données : " . $e->getMessage());
    }
    ?>

6. Configurez les paramètres de connexion à la base de données NoSQL dans le fichier `config/config_nosql.php` :

    ```php
    <?php
    require __DIR__ . '/../vendor/autoload.php'; // Charger la bibliothèque MongoDB via Composer
    
    try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $mongoDB = $client;
    } catch (Exception $e) {
    die("Erreur de connexion à MongoDB : " . $e->getMessage());
    }
    ?>


## Utilisation

1. Une fois que vous avez configuré les base de données et démarré le serveur, ouvrez un navigateur et accédez à la page d'accueil du projet :

    ```bash
    http://localhost/arcadia/index.php
    ```

2. Depuis la page d'accueil, vous pouvez naviguer vers les sections **Habitats**, **Services**, **Contact**, etc.

3. Sur la page des habitats, vous pouvez voir la liste des habitats. Cliquez sur un habitat pour voir les animaux présents. cliquez sur un animal pout voir les détails de cet animal dans une modale interactive.

La modale vous montrera :
   - L'image de l'animal
   - Son état de santé
   - Son type de nourriture
   - Son grammage
   - Le nombre de vues

Chaque fois que vous ouvrez la modale d'un animal, le nombre de vues est mis à jour dans la base de données.
   
4. Sur la page Services utilisant MongoDB pour afficher dynamiquement les services disponibles au zoo, vous pouvez ajouter, modifier ou supprimer des services directement dans la collection services de MongoDB ou en passant par une accès administrateur ou employé.
   
5. Avis des visiteurs: Les visiteurs peuvent laisser un avis sur leur expérience au zoo. Ces avis sont stockés dans la collection reviews de MongoDB et peuvent être affichés ou filtrés sur une page dédiée(employe_dashboard.php).

## licence
MIT

## Voici quelques exemples de la requête SQL utilisée:

MySQL

```php
- Pour mettre à jour les informations du modal sur les aniamaux à chaque fois que ses détails sont consultés :

document.getElementById('modalImage').src = data.image || 'placeholder.jpg';
document.getElementById('modalName').textContent = data.name || 'Nom non disponible';
document.getElementById('modalFood').textContent = 'Nourriture donnée : ' + (data.food || 'Non disponible');
document.getElementById('modalWeight').textContent = 'Grammage : ' + (data.weight || 'Non disponible') + ' g';
document.getElementById('modalHealthStatus').textContent = 'État de santé : ' + (data.health_status || 'Non disponible');
document.getElementById('modalViews').textContent = 'Nombre de vues : ' + (data.views || '0');


- Requête préparée pour éviter les injections SQL lors d’une insertion d'un message de contact 

$stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
$stmt->execute([$name, $email, $message]);

- Sélection avec protection contre les injections SQL 

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

```

NoSQL (MongoDB)

```php
- Ajout d'un service 

$insertResult = $collection->insertOne([
'name' => $name,
'description' => $description,
'content' => $content,
'image' => $image_path
]);
echo "<p>Service ajouté avec succès !</p>";


- Récupération des avis des visiteurs 

$collection_reviews = $client->zooarcadia->reviews;
$reviews = $collection_reviews->find()->toArray();
