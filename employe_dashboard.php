<?php
    session_start();

    include 'config/config_sql.php';  // Connexion SQL

    // Connexion à MongoDB pour les services
    require 'vendor/autoload.php'; // Bibliothèque MongoDB installée via Composer
    $client = new MongoDB\Client("mongodb://localhost:27017"); // URL local
    $db = $client->zooarcadia; // Nom de la base de données MongoDB
    $servicesCollection = $db->services; // Nom de la collection des services

    // Vérifier si l'utilisateur est un employé
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employe') {
    header('Location: connexion.php');
    exit();
    }

    // Gestion de la déconnexion
    if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: connexion.php');
    exit();
    }

    // Gestion des Avis - NoSQL (MongoDB)
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['validate_review'])) {
    $review_id = $_POST['review_id'] ?? '';
    $is_validated = isset($_POST['is_validated']) && $_POST['is_validated'] === '1';

    try {
        // Vérifier l'ID MongoDB
        if (!preg_match('/^[a-f0-9]{24}$/', $review_id)) {
            throw new Exception('ID de l\'avis invalide.');
        }
        $mongoId = new MongoDB\BSON\ObjectId($review_id);

        // Mettre à jour le statut de validation
        $collection = $client->zooarcadia->reviews;
        $updateResult = $collection->updateOne(
            ['_id' => $mongoId],
            ['$set' => ['is_validated' => $is_validated]]
        );

        if ($updateResult->getModifiedCount() === 0) {
            throw new Exception('Aucun avis mis à jour. L\'ID est peut-être incorrect.');
        }
        $message = "Avis mis à jour avec succès !";
    } catch (Exception $e) {
        $message = "Erreur lors de la mise à jour de l'avis : " . htmlspecialchars($e->getMessage());
    }
    }

    // Récupérer les avis - NoSQL (MongoDB)
    $collection_reviews = $client->zooarcadia->reviews;
    $reviews = $collection_reviews->find()->toArray();

    // Gestion des animaux pour l'alimentation
    $stmt_animals = $pdo->prepare("SELECT id, name FROM animals ORDER BY name ASC"); //par ordre alphabétique
    $stmt_animals->execute();
    $animals = $stmt_animals->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les services de la collection MongoDB
    $services = [];
    try {
    $services = $servicesCollection->find()->toArray();
    } catch (Exception $e) {
    $services = []; // Si la récupération échoue, définir un tableau vide
    }

    // Ajouter une alimentation dans la base SQL
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_feeding'])) {
    $animal_id = $_POST['animal_id'] ?? '';
    $food_type = $_POST['food_type'] ?? '';
    $grammage = $_POST['grammage'] ?? '';
    $feeding_time = $_POST['feeding_time'] ?? '';

    // Valider les champs
    if (empty($animal_id) || empty($food_type) || empty($grammage) || empty($feeding_time)) {
        $message = "Veuillez remplir tous les champs.";
    } else {
        try {
            // Insérer dans la base de données SQL (table feeding_logs)
            $stmt = $pdo->prepare("INSERT INTO feeding_logs (animal_id, user_id, food_type, grammage, feeding_time) 
                                   VALUES (:animal_id, :user_id, :food_type, :grammage, :feeding_time)");
            $stmt->bindParam(':animal_id', $animal_id);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);  // ID de l'utilisateur (employé)
            $stmt->bindParam(':food_type', $food_type);
            $stmt->bindParam(':grammage', $grammage);
            $stmt->bindParam(':feeding_time', $feeding_time);
            $stmt->execute();

            // Message de confirmation
            $message = "Alimentation ajoutée avec succès !";
        } catch (PDOException $e) {
            $message = "Erreur lors de l'ajout de l'alimentation : " . htmlspecialchars($e->getMessage());
        }
    }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Employé</title>
    <link rel="stylesheet" href="dashboard1/style.css">
</head>
<body>
    <div class="header">
        <p>Bienvenue, <strong><?= htmlspecialchars($_SESSION['role']); ?></strong></p>
        <form method="POST" action="">
        <button type="submit" name="logout" class="logout-btn">Déconnexion</button>
        </form>
    </div>
    <h1>Tableau de Bord Employé</h1>
    <h2>Gestion des Avis</h2>
    <?php if (!empty($message)): ?>
        <p style="color: green;"><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>Nom du Visiteur</th>
                <th>Avis</th>
                <th>Validé</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?= htmlspecialchars($review['visitor_name']); ?></td>
                    <td><?= htmlspecialchars($review['review']); ?></td>
                    <td><?= !empty($review['is_validated']) && $review['is_validated'] === true ? 'Oui' : 'Non'; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="review_id" value="<?= htmlspecialchars($review['_id']); ?>">
                            <select name="is_validated">
                                <option value="1" <?= !empty($review['is_validated']) && $review['is_validated'] === true ? 'selected' : ''; ?>>Valider</option>
                                <option value="0" <?= empty($review['is_validated']) || $review['is_validated'] === false ? 'selected' : ''; ?>>Invalider</option>
                            </select>
                            <button type="submit" name="validate_review">Mettre à jour</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Ajouter une Alimentation</h2>
    <form method="POST" action="employe_dashboard.php">
        <label for="animal_id">Animal :</label>
        <select name="animal_id" id="animal_id" required>
            <?php foreach ($animals as $animal): ?>
                <option value="<?= $animal['id']; ?>"><?= htmlspecialchars($animal['name']); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="food_type">Type de Nourriture :</label>
        <input type="text" name="food_type" id="food_type" required>

        <label for="grammage">Quantité (en grammes) :</label>
        <input type="number" name="grammage" id="grammage" step="0.01" required>

        <label for="feeding_time">Date et Heure :</label>
        <input type="datetime-local" name="feeding_time" id="feeding_time" required>

        <button type="submit" name="add_feeding">Ajouter</button>
    </form>

    <h2>Gestion des Services</h2>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Contenu</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($services)): ?>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td>
                            <img src="<?= htmlspecialchars($service['image']); ?>" 
                                 alt="<?= htmlspecialchars($service['name']); ?>" 
                                 width="100">
                        </td>
                        <td><?= htmlspecialchars($service['name']); ?></td>
                        <td><?= htmlspecialchars($service['description']); ?></td>
                        <td>
                            <?= htmlspecialchars(mb_strimwidth($service['content'] ?? 'Pas de contenu', 0, 100, '...')); ?>
                        </td>
                        <td>
                            <a href="edit_service.php?id=<?= (string)$service['_id']; ?>">Modifier</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align:center;">Aucun service disponible.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
