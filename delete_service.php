<?php
    session_start();
    include 'config/config_nosql.php'; // Inclure la configuration MongoDB

    // Vérifier si l'utilisateur est un administrateur
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit();
    }

    // Vérifier si l'ID du service est fourni et est au bon format
    if (isset($_GET['id']) && preg_match('/^[a-f0-9]{24}$/', $_GET['id'])) {
    $service_id = $_GET['id'];

    try {
    // Préparer la collection services de MongoDB
    $collection = $mongoDB->zooarcadia->services;

    // Supprimer le document du service correspondant à l'ID
    $result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($service_id)]);

    if ($result->getDeletedCount() > 0) {
    // Rediriger vers le tableau de bord après la suppression
    header('Location: admin_dashboard.php');
    exit();
    } else {
    echo 'Aucun service trouvé avec cet ID.';
    }
    } catch (Exception $e) {
    echo 'Erreur lors de la suppression du service : ' . htmlspecialchars($e->getMessage());
    }
    } else {
    echo 'ID de service non valide. Assurez-vous que l\'ID est un identifiant MongoDB valide.';
    }
?>
