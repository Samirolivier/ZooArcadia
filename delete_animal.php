<?php
    session_start();
    include 'config/config_sql.php';

    // Vérifier si l'utilisateur est un administrateur
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit();
    }

    // Vérifier si l'ID de l'animal est fourni
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $animal_id = $_GET['id'];

    // Préparer et exécuter la requête de suppression
    $stmt = $pdo->prepare("DELETE FROM animals WHERE id = ?");
    $stmt->execute([$animal_id]);

    // Rediriger vers le tableau de bord après la suppression
    header('Location: admin_dashboard.php');
    exit();
    } else {
    echo 'ID d\'animal non valide.';
    }
?>