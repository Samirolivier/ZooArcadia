<?php
include 'config/config_nosql.php'; // Assurez-vous que ce fichier contient la connexion MongoDB

// Vérifiez que l'ID est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID invalide ou non fourni.');
}

$id = $_GET['id'];

try {
    // Vérifiez que l'ID est un ObjectId valide
    if (!preg_match('/^[a-f\d]{24}$/i', $id)) {
        throw new Exception('ID MongoDB invalide.');
    }

    // Convertir l'ID en ObjectId
    $mongoId = new MongoDB\BSON\ObjectId($id);

    // Accéder à la collection `reviews` dans votre base MongoDB
    $collection = $client->zooarcadia->reviews;

    // Mettre à jour le statut du document
    $updateResult = $collection->updateOne(
        ['_id' => $mongoId], // Critère pour trouver le document
        ['$set' => ['status' => 'approved']] // Champs à mettre à jour
    );

    // Vérifiez si un document a été modifié
    if ($updateResult->getModifiedCount() === 0) {
        throw new Exception('Aucun document mis à jour. L\'ID est peut-être incorrect.');
    }

    // Rediriger l'utilisateur après la mise à jour
    header('Location: employe_dashboard.php');
    exit();

} catch (Exception $e) {
    // En cas d'erreur, afficher un message
    echo 'Erreur : ' . $e->getMessage();
    exit();
}
?>
