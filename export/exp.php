<?php
$pdo = new PDO('mysql:host=localhost;dbname=zooarcadia', 'root', '');

$stmt = $pdo->query("SELECT * FROM feeding_logs");
$file = fopen('feeding_logs.csv', 'w');

// Ajouter les colonnes
$columns = array_keys($stmt->fetch(PDO::FETCH_ASSOC));
fputcsv($file, $columns);

// Ajouter les données
$stmt->execute(); // Réexécuter la requête
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($file, $row);
}

fclose($file);
echo "Exportation réussie dans feeding_logs.csv";
?>
