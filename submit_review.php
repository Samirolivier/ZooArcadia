<?php
include 'config/config_nosql.php'; // Inclure la configuration MongoDB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $visitorName = $_POST['visitor_name'] ?? '';
    $reviewText = $_POST['review'] ?? '';

    if (!empty($visitorName) && !empty($reviewText)) {
        try {
            // Accéder à la collection reviews
            $collection = $mongoDB->zooarcadia->reviews;

            // Ajouter l'avis avec un statut "non validé"
            $result = $collection->insertOne([
                'visitor_name' => $visitorName,
                'review' => $reviewText,
                'status' => 'non validé', // Par défaut, l'avis n'est pas encore validé
                'created_at' => new MongoDB\BSON\UTCDateTime()
            ]);

            if ($result->getInsertedCount() === 1) {
                echo "<p>Votre avis a été soumis avec succès et est en attente de validation.</p>";
            } else {
                echo "<p>Une erreur s'est produite lors de l'envoi de votre avis.</p>";
            }
        } catch (Exception $e) {
            echo "<p>Erreur lors de l'accès à MongoDB : " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Veuillez remplir tous les champs du formulaire.</p>";
    }
} else {
    echo "<p>Méthode non autorisée.</p>";
}
?>
