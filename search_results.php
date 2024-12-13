<?php
    session_start();
    include 'config/config_sql.php';

    $searchResult = null;
    $errorMessage = null;

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query']) && !empty($_GET['query'])) {
    $query = trim($_GET['query']);
    $searchTerm = '%' . $query . '%'; // Recherche partielle (contient le terme)

    // Déboguer la variable de recherche
    var_dump($query);

    // Préparer la requête pour chercher le nom de l'animal
    $sql = "SELECT * FROM animals WHERE name LIKE :query LIMIT 1"; // Limiter à 1 pour ne récupérer qu'un seul animal si trouvé
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);

    // Exécuter la requête et vérifier si elle a réussi
    try {
        $stmt->execute();
        // Déboguer pour voir si les données sont retournées
        $searchResult = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($searchResult);  // Affiche les résultats pour déboguer
    } catch (PDOException $e) {
        // Afficher une erreur si la requête échoue
        echo "Erreur lors de la requête : " . $e->getMessage();
    }

    if (!$searchResult) {
        // Si aucun animal n'est trouvé
        $errorMessage = "L'animal que vous recherchez n'existe pas dans le zoo.";
    } else {
        // Si un animal est trouvé, rediriger vers habitat_detail.php avec l'ID de l'animal
        header("Location: habitat_detail.php?id=" . $searchResult['id']);
        exit; // Assurez-vous d'arrêter l'exécution du script après la redirection
    }
    } else {
    $errorMessage = "Veuillez entrer un nom d'animal.";
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de Recherche</title>
    <!-- Bootstrap pour les modals -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Résultats de Recherche</h1>

        <!-- Formulaire de recherche -->
        <form class="d-flex" method="GET" action="search_results.php">
            <input class="form-control me-2" type="search" name="query" placeholder="Rechercher un animal" aria-label="Recherche" required>
            <button class="btn btn-outline-success" type="submit">Rechercher</button>
        </form>

        <!-- Afficher un message si aucun animal n'est trouvé -->
        <?php if ($errorMessage): ?>
            <div class="alert alert-danger mt-3">
                <?= htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

    </div>

    <!-- Inclure jQuery et Bootstrap JS pour activer les modals -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
