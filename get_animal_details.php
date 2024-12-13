<?php
    include 'config/config_sql.php'; // Inclure la configuration pour PDO

    // Vérifie si un ID d'animal est passé dans l'URL
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id > 0) {
    try {
        // Démarrer une transaction pour regrouper les mises à jour
        $pdo->beginTransaction();

        // Mettre à jour les vues pour l'animal sélectionné
        $sql_update_views = "UPDATE animals SET views = views + 1 WHERE id = ?";
        $stmt_update_views = $pdo->prepare($sql_update_views);
        $stmt_update_views->execute([$id]);

        // Récupérer les détails de l'animal
        $stmt_animal = $pdo->prepare("SELECT id, name, image, health_status, views FROM animals WHERE id = ?");
        $stmt_animal->execute([$id]);
        $animal = $stmt_animal->fetch(PDO::FETCH_ASSOC);

        if ($animal) {
            // Récupérer les détails de la dernière alimentation
            $stmt_feeding = $pdo->prepare("
                SELECT food_type, grammage, feeding_time 
                FROM feeding_logs 
                WHERE animal_id = ? 
                ORDER BY feeding_time DESC 
                LIMIT 1
            ");
            $stmt_feeding->execute([$id]);
            $feeding = $stmt_feeding->fetch(PDO::FETCH_ASSOC);

            // Construire la réponse JSON
            $response = [
                'id' => $animal['id'],
                'name' => htmlspecialchars($animal['name']),
                'image' => htmlspecialchars($animal['image'] ?: 'placeholder.jpg'), // Image par défaut
                'health_status' => htmlspecialchars($animal['health_status']),
                'food' => $feeding ? htmlspecialchars($feeding['food_type']) : 'Non disponible',
                'weight' => $feeding ? htmlspecialchars($feeding['grammage']) : 'Non disponible',
                'feeding_time' => $feeding ? htmlspecialchars($feeding['feeding_time']) : 'Non disponible',
                'views' => $animal['views'] + 1 // Nombre de vues après mise à jour
            ];

            // Confirmer la transaction
            $pdo->commit();

            // Retourner les détails de l'animal en format JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // Si aucun animal n'est trouvé, annuler la transaction
            $pdo->rollBack();
            http_response_code(404); // Code HTTP 404 : Non trouvé
            echo json_encode(['error' => 'Animal non trouvé']);
        }
    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $pdo->rollBack();
        http_response_code(500); // Code HTTP 500 : Erreur serveur
        echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
    }
    } else {
    // Si l'ID est invalide ou manquant, envoyer une réponse d'erreur
    http_response_code(400); // Code HTTP 400 : Mauvaise requête
    echo json_encode(['error' => 'ID non valide ou non fourni']);
    }


?>
