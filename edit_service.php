<?php
    session_start();
    require 'vendor/autoload.php'; // MongoDB PHP Library installé via Composer

    // Connexion à MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->zooarcadia; // Ma base de données MongoDB
    $collection = $db->services; // Nom de la collection des services

    // Vérifier si l'utilisateur est un administrateur ou un employé
    if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employe')) {
    header('Location: connexion.php');
    exit();
    }

    // Identifier le rôle de l'utilisateur connecté
    $is_admin = ($_SESSION['role'] === 'admin');
    $is_employe = ($_SESSION['role'] === 'employe');

    // Récupérer l'ID du service (s'il existe)
    $service_id = isset($_GET['id']) ? $_GET['id'] : null;

    // Si un ID est spécifié, assurez-vous qu'il est un ObjectId valide
    if ($service_id) {
    try {
        // Vérifier si l'ID est un ObjectId valide (24 caractères hexadécimaux)
        if (preg_match('/^[a-f0-9]{24}$/', $service_id)) {
            // Convertir l'ID en ObjectId
            $service_id = new MongoDB\BSON\ObjectId($service_id);
        } else {
            throw new Exception("L'ID du service n'est pas valide.");
        }
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage();
        exit();
    }
    }

    // Récupérer les détails du service si l'ID est fourni et valide
    $service = null;
    if ($service_id) {
    $service = $collection->findOne(['_id' => $service_id]);

    // Si aucun service n'est trouvé avec cet ID, afficher une erreur
    if (!$service) {
        echo "Erreur: Service introuvable.";
        exit();
    }
    }

    // Gestion des modifications ou ajout
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $image = $_FILES['image'];

    // Gestion de l'image
    if ($image['error'] === UPLOAD_ERR_OK) {
        $image_name = uniqid() . '_' . basename($image['name']);
        $image_path = 'images/images/services/' . $image_name;

        // Déplacer le fichier téléchargé dans le répertoire défini
        if (move_uploaded_file($image['tmp_name'], $image_path)) {
            // Si une image existait auparavant, la supprimer
            if (isset($service['image']) && file_exists('images/images/services/' . $service['image'])) {
                unlink('images/images/services/' . $service['image']);
            }
        } else {
            echo "<p>Erreur lors du téléchargement de l'image.</p>";
        }
    } else {
        // Conserver l'ancienne image si aucune nouvelle image n'est téléchargée
        $image_path = isset($service['image']) ? $service['image'] : null;
    }

    if ($service_id) {
        // Mise à jour du service
        $updateResult = $collection->updateOne(
            ['_id' => $service_id],
            ['$set' => ['name' => $name, 'description' => $description, 'content' => $content, 'image' => $image_path]]
        );
        echo "<p>Service mis à jour avec succès !</p>";
    } else {
        // Ajout d'un nouveau service
        $insertResult = $collection->insertOne([
            'name' => $name,
            'description' => $description,
            'content' => $content,
            'image' => $image_path
        ]);
        echo "<p>Service ajouté avec succès !</p>";
    }
 
    
    // Redirection en fonction du rôle après soumission
    $redirect_page = $is_admin ? 'admin_dashboard.php' : 'employe_dashboard.php';
    header("Location: $redirect_page");
    exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $service_id ? "Modifier le Service" : "Ajouter un Service" ?></title>
    <link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>
    <h1><?= $service_id ? "Modifier le Service" : "Ajouter un Service" ?></h1>
    <form method="POST" action="edit_service.php?id=<?= $service_id ?>" enctype="multipart/form-data">
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($service['name'] ?? '') ?>" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description" rows="4" required><?= htmlspecialchars($service['description'] ?? '') ?></textarea>

        <label for="content">Contenu :</label> <!-- Nouveau champ pour le contenu -->
        <textarea name="content" id="content" rows="6"><?= htmlspecialchars($service['content'] ?? '') ?></textarea>

        <label for="image">Image :</label>
        <input type="file" name="image" id="image">
        <?php if (isset($service['image']) && $service['image']): ?>
            <p><img src="images/images/services/<?= htmlspecialchars($service['image']) ?>" alt="<?= htmlspecialchars($service['name']) ?>" width="150"></p>
        <?php endif; ?>

        <button type="submit"><?= $service_id ? "Modifier le Service" : "Ajouter le Service" ?></button>
    </form>
    <a href="<?= $is_admin ? 'admin_dashboard.php' : 'employe_dashboard.php' ?>">⬅️Retourner au tableau de bord</a>
</body>
</html>
