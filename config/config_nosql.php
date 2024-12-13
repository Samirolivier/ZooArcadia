<?php

    require __DIR__ . '/../vendor/autoload.php'; // Charger la bibliothèque MongoDB via Composer

    try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $mongoDB = $client; // Assurez-vous que cette variable est définie globalement
    } catch (Exception $e) {
    die("Erreur de connexion à MongoDB : " . $e->getMessage());
    }
?>