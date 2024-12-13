<?php
session_start();
include 'config/config_sql.php';

// Vérifier si l'utilisateur est un administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit();
}

// Gestion des ajouts d'un animal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $species = $_POST['species'];
    $habitat_id = $_POST['habitat_id'];
    $image = $_FILES['image'];

    // Initialiser la variable image_path
    $image_path = null;

    // Gestion de l'image si une nouvelle est téléchargée
    if ($image['error'] === UPLOAD_ERR_OK) {
        $image_name = uniqid() . '_' . basename($image['name']);
        $image_path = 'images/images/animals/' . $image_name;

        // Déplacer le fichier téléchargé dans le répertoire (images/images/animals)
        if (!move_uploaded_file($image['tmp_name'], $image_path)) {
            echo "<p>Erreur lors du téléchargement de l'image.</p>";
            $image_path = null;  // Aucune image ne sera enregistrée si l'upload échoue
        }
    }

    // Insertion de l'animal dans la base de données
    $stmt = $pdo->prepare("INSERT INTO animals (name, species, habitat_id, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $species, $habitat_id, $image_path]);

    echo "<p>Animal ajouté avec succès !</p>";
    header('Location: admin_dashboard.php');
    exit();
}

// Récupérer la liste des habitats pour le menu déroulant
$stmt_habitats = $pdo->prepare("SELECT id, name FROM habitats");
$stmt_habitats->execute();
$habitats = $stmt_habitats->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Animal</title>
    <link rel="stylesheet" href="dashboard1/styles.css">
</head>
<body>
    <h1>Ajouter un Animal</h1>
    
    <form method="POST" action="add_animal.php" enctype="multipart/form-data">
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" required>

        <label for="species">Espèce :</label>
        <input type="text" name="species" id="species" required>

        <label for="habitat_id">Habitat :</label>
        <select name="habitat_id" id="habitat_id" required>
            <option value="">Sélectionner un habitat</option>
            <?php foreach ($habitats as $habitat): ?>
                <option value="<?= $habitat['id']; ?>"><?= htmlspecialchars($habitat['name']); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="image">Image :</label>
        <input type="file" name="image" id="image">

        <button type="submit">Ajouter l'Animal</button>
    </form>

    <a href="admin_dashboard.php">⬅️Retourner au tableau de bord</a>
</body>
</html>
