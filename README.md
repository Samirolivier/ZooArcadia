# ZooArcadia-Gestion des Habitats et Animaux

Bienvenue sur le projet de gestion des habitats et des animaux du Zoo Arcadia. Ce projet permet de consulter les habitats du zoo ainsi que les détails sur les animaux qui y résident, tout en incluant des informations telles que leur état de santé, leur alimentation, leur grammage et l'heure de leur dernière alimentation. Le projet inclut également la gestion des services proposés par le zoo et des avis (reviews) des visiteurs grâce à l'intégration de MongoDB.
Fonctionnalités
1.	Liste des habitats : Chaque habitat contient une description et affiche les animaux présents dans celui-ci.
2.	Détails des animaux : En cliquant sur un animal, une modale affiche des informations détaillées comme l'image, le nom, l'état de santé, l'alimentation et le grammage.
3.	Système de vues : Chaque fois qu'un utilisateur visualise les détails d'un animal, le compteur de vues de cet animal est incrémenté.
4.	Gestion des services : Une collection MongoDB services permet de stocker et de récupérer les services offerts par le zoo.
5.	Gestion des avis : Une collection MongoDB reviews permet de gérer les avis des visiteurs du zoo.
Technologies Utilisées
Front-end :
•	HTML, CSS
•	JavaScript : Pour la gestion des modales et des requêtes AJAX.
•	Effets de survol pour une meilleure interactivité.
Back-end :
•	PHP : Pour la génération dynamique des pages et la gestion des requêtes.
•	PDO (PHP Data Objects) : Pour la gestion des interactions avec la base de données relationnelle MySQL.
•	MongoDB : Pour gérer des collections supplémentaires (services et reviews).
Base de données :
•	MySQL : Pour stocker les informations sur les animaux, les habitats, et les logs d'alimentation.
•	MongoDB : Pour les services et les avis des visiteurs.
Prérequis
•	PHP >= 8.1.10
•	MySQL
•	MongoDB
•	Serveur web Apache 2.4.54
Installation
1.	Clonez ce dépôt sur votre machine locale :
https://github.com/Samirolivier/ZooArcadia
2.	Naviguez dans le dossier du projet :
cd ZooArcadia
3.	Importez la base de données MySQL et NoSQL :

•	Importez le fichier zooarcadia_9_tables_bon.sql fourni dans le dossier export/. Vous pouvez le faire via phpMyAdmin ou en ligne de commande :
mysql -u root -p zooarcadia < export/ zooarcadia_9_tables_bon.sql
•	Importez les fichiers zooarcadia.reviews.json et zooarcadia.services.json fourni dans le dossier export/. Vous pouvez le faire via MongoDb Compass ou en ligne de commande :
mongoimport --db zooarcadia --collection services --file zooarcadia.services.json –jsonArray
Mais avant assurez-vous de démarrer le serveur MongoDB avec mongod.

4.	Configurez les paramètres de connexion à la base de données MySQL dans le fichier config/config_sql.php :

1.	<?php
2.	    $host = 'localhost';
3.	    $dbname = 'zooarcadia';
4.	    $username = 'root';
5.	    $password = ''; 
6.	
7.	    try {
8.	    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
9.	    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
10.	    } catch (PDOException $e) {
11.	    die("Erreur de connexion à la base de données : " . $e->getMessage());
12.	    }
13.	?>

5.	Configurez MongoDB dans config/config_nosql.php :

1.	<?php
2.	
3.	    require __DIR__ . '/../vendor/autoload.php'; // Charger la bibliothèque MongoDB via Composer
4.	
5.	    try {
6.	    $client = new MongoDB\Client("mongodb://localhost:27017");
7.	    $mongoDB = $client;
8.	    } catch (Exception $e) {
9.	    die("Erreur de connexion à MongoDB : " . $e->getMessage());
10.	    }
11.	?>

6.	Démarrez votre serveur web et accédez à l'application :
•	Assurez-vous que votre serveur pointe vers le dossier du projet.
•	Ouvrez un navigateur et accédez à :
http://localhost/arcadia/index.php

Utilisation
1.	Navigation principale :
o	Depuis la page d'accueil, accédez aux sections Habitats, Services, Contact, etc.
2.	Page des habitats :
o	Voir la liste des habitats et cliquer sur un habitat pour voir les animaux présents.
o	Cliquer sur un animal pour afficher ses détails dans une modale interactive. Les informations incluent l'image, l'état de santé, le type de nourriture, le grammage, et le compteur de vues.
3.	Services :
o	La page Services utilise MongoDB pour afficher dynamiquement les services disponibles au zoo. Vous pouvez ajouter, modifier ou supprimer des services directement dans la collection services de MongoDB.
4.	Avis des visiteurs :
o	Les visiteurs peuvent laisser un avis sur leur expérience au zoo. Ces avis sont stockés dans la collection reviews de MongoDB et peuvent être affichés ou filtrés sur une page dédiée.
Exemples de requêtes
MySQL :
•	Mise à jour des informations du modal sur les aniamaux
document.getElementById('modalImage').src = data.image || 'placeholder.jpg';
document.getElementById('modalName').textContent = data.name || 'Nom non disponible';
document.getElementById('modalFood').textContent = 'Nourriture donnée : ' + (data.food || 'Non disponible');
document.getElementById('modalWeight').textContent = 'Grammage : ' + (data.weight || 'Non disponible') + ' g';
document.getElementById('modalHealthStatus').textContent = 'État de santé : ' + (data.health_status || 'Non disponible');
document.getElementById('modalViews').textContent = 'Nombre de vues : ' + (data.views || '0');

•	Requête préparée pour éviter les injections SQL lors d’une insertion d'un message de contact :
$stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
$stmt->execute([$name, $email, $message]);

•	Sélection avec protection contre les injections SQL :
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();


MongoDB :
•	Ajout d'un service :
$insertResult = $collection->insertOne([
'name' => $name,
'description' => $description,
'content' => $content,
'image' => $image_path
]);
echo "<p>Service ajouté avec succès !</p>";

•	Récupération des avis des visiteurs – NoSQL (MongoDB):
$collection_reviews = $client->zooarcadia->reviews;
$reviews = $collection_reviews->find()->toArray();
