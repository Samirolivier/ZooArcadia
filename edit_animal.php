<?php
    session_start();
    include 'config/config_sql.php';

    // Vérifier si l'utilisateur est un administrateur
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit();
    }

    $animal_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Récupérer les détails de l'animal si un ID est fourni
    if ($animal_id) {
    $stmt = $pdo->prepare("SELECT * FROM animals WHERE id = ?");
    $stmt->execute([$animal_id]);
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Gestion des modifications ou ajout
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $species = $_POST['species'];
    $habitat_id = $_POST['habitat_id'];
    $image = $_FILES['image'];
    
    // Définir un chemin pour stocker l'image
    $image_path = isset($animal['image']) ? $animal['image'] : null;

    // Gestion de l'image si une nouvelle est téléchargée
    if ($image['error'] === UPLOAD_ERR_OK) {
        $image_name = uniqid() . '_' . basename($image['name']);
        $image_path = 'images/images/animals/' . $image_name;

    // Déplacer le fichier téléchargé dans le répertoire (images/images/animals)
    if (move_uploaded_file($image['tmp_name'], $image_path)) {
    // Supprimer l'ancienne image si elle existe
    if (isset($animal['image']) && file_exists('images/images/animals/' . $animal['image'])) {
        unlink('images/images/animals/' . $animal['image']);
    }
    } else {
        echo "<p>Erreur lors du téléchargement de l'image.</p>";
        $image_path = $animal['image'];  // Conserver l'ancienne image en cas d'échec
    }
    }

    if ($animal_id) {
    // Mise à jour de l'animal
    $stmt = $pdo->prepare("UPDATE animals SET name = ?, species = ?, habitat_id = ?, image = ? WHERE id = ?");
    $stmt->execute([$name, $species, $habitat_id, $image_path, $animal_id]);
    echo "<p>Animal mis à jour avec succès !</p>";
    } else {
    // Ajout d'un nouvel animal
    $stmt = $pdo->prepare("INSERT INTO animals (name, species, habitat_id, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $species, $habitat_id, $image_path]);
    echo "<p>Animal ajouté avec succès !</p>";
    }

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
    <title><?= $animal_id ? "Modifier l'Animal" : "Ajouter un Animal" ?></title>
    <link rel="stylesheet" href="styles/admin_dashboard.css">
</head>
<body>
    <h1><?= $animal_id ? "Modifier l'Animal" : "Ajouter un Animal" ?></h1>
    
    <form method="POST" action="edit_animal.php?id=<?= $animal_id ?>" enctype="multipart/form-data">
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($animal['name'] ?? '') ?>" required>

        <label for="species">Espèce :</label>
        <input type="text" name="species" id="species" value="<?= htmlspecialchars($animal['species'] ?? '') ?>" required>

        <label for="habitat_id">Habitat :</label>
        <select name="habitat_id" id="habitat_id" required>
            <option value="">Sélectionner un habitat</option>
            <?php foreach ($habitats as $habitat): ?>
                <option value="<?= $habitat['id']; ?>" <?= ($animal['habitat_id'] ?? '') == $habitat['id'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($habitat['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="image">Image :</label>
        <input type="file" name="image" id="image">
        <?php if (isset($animal['image']) && $animal['image']): ?>
            <p>
                <img src="images/images/animals/<?= htmlspecialchars($animal['image']) ?>" alt="<?= htmlspecialchars($animal['name']) ?>" width="150">
                <br>
                <span>Image actuelle</span>
            </p>
        <?php endif; ?>

        <button type="submit"><?= $animal_id ? "Modifier l'Animal" : "Ajouter l'Animal" ?></button>
    </form>

    <a href="admin_dashboard.php">⬅️Retourner au tableau de bord</a>
</body>
</html>
