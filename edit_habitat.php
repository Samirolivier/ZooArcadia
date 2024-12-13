<?php
    session_start();
    include 'config/config_sql.php';

    // Vérifier si l'utilisateur est un administrateur
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit();
    }

    $habitat_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Récupérer les détails de l'habitat si l'ID est fourni
    if ($habitat_id) {
    $stmt = $pdo->prepare("SELECT * FROM habitats WHERE id = ?");
    $stmt->execute([$habitat_id]);
    $habitat = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Gestion des modifications ou ajout
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $content = $_POST['content']; 

    // Gestion de l'image
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $image_name = uniqid() . '_' . basename($image['name']);
        $image_path = 'images/images/habitats/' . $image_name;

        // Déplacer le fichier téléchargé dans le répertoire (images/images/habitats)
        if (move_uploaded_file($image['tmp_name'], $image_path)) {
            // Si une image existait auparavant, la supprimer
            if (isset($habitat['image']) && file_exists('images/images/habitats/' . $habitat['image'])) {
                unlink('images/images/habitats/' . $habitat['image']);
            }
        } else {
            echo "<p>Erreur lors du téléchargement de l'image.</p>";
        }
    } else {
        // Conserver l'ancienne image si aucune nouvelle image n'est téléchargée
        $image_path = isset($habitat['image']) ? $habitat['image'] : null;
    }

    // Mise à jour de l'habitat ou ajout d'un nouvel habitat
    if ($habitat_id) {
        // Mise à jour de l'habitat
        $stmt = $pdo->prepare("UPDATE habitats SET name = ?, description = ?, content = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $description, $content, $image_path, $habitat_id]);
        echo "<p>Habitat mis à jour avec succès !</p>";
    } else {
        // Ajout d'un nouvel habitat
        $stmt = $pdo->prepare("INSERT INTO habitats (name, description, content, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $description, $content, $image_path]);
        echo "<p>Habitat ajouté avec succès !</p>";
    }
    header('Location: admin_dashboard.php');
    exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $habitat_id ? "Modifier l'Habitat" : "Ajouter un Habitat" ?></title>
    <link rel="stylesheet" href="styles/admin_dashboard.css">
</head>
<body>
    <h1><?= $habitat_id ? "Modifier l'Habitat" : "Ajouter un Habitat" ?></h1>
    <form method="POST" action="edit_habitat.php?id=<?= $habitat_id ?>" enctype="multipart/form-data">
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($habitat['name'] ?? '') ?>" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description" rows="4" required><?= htmlspecialchars($habitat['description'] ?? '') ?></textarea>

        <label for="content">Contenu :</label> <!-- Nouveau champ pour le contenu -->
        <textarea name="content" id="content" rows="6"><?= htmlspecialchars($habitat['content'] ?? '') ?></textarea>

        <label for="image">Image :</label>
        <input type="file" name="image" id="image">
        <?php if (isset($habitat['image']) && $habitat['image']): ?>
            <p><img src="images/images/habitats/<?= htmlspecialchars($habitat['image']) ?>" alt="<?= htmlspecialchars($habitat['name']) ?>" width="150"></p>
        <?php endif; ?>

        <button type="submit"><?= $habitat_id ? "Modifier l'Habitat" : "Ajouter l'Habitat" ?></button>
    </form>
    <a href="admin_dashboard.php">⬅️Retourner au tableau de bord</a>
</body>
</html>
