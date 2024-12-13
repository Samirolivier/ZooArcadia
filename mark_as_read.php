<?php
    include 'config/config_sql.php'; // Connexion à la base de données

    if (isset($_GET['id'])) {
    $messageId = intval($_GET['id']);

    // Mettre à jour le message pour le marquer comme lu
    $sql = "UPDATE contact_messages SET is_read = TRUE WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$messageId]);

    // Rediriger vers la page admin_messages.php
    header("Location: admin_messages.php");
    exit();
    } else {
    echo "ID de message non fourni.";
    }
?>
