<?php
    include 'config/config_sql.php';

    $animal_id = $_POST['animal_id'];
    $food_type = $_POST['food_type'];
    $grammage = $_POST['grammage'];
    $feeding_time = $_POST['feeding_time'];

    $stmt = $pdo->prepare("INSERT INTO feeding_logs (animal_id, food_type, grammage, feeding_time) VALUES (?, ?, ?, ?)");
    $stmt->execute([$animal_id, $food_type, $grammage, $feeding_time]);

    header('Location: dashboard_employe.php');
?>
