<?php 
    $role = "null";
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employe') {
    header('Location: connexion.php');
    exit();
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit();
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'veterinaire') {
    header('Location: connexion.php');
    exit();
    }
?>
