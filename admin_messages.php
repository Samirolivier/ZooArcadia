<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="dashboard1/style.css">
</head>
<body>

    <?php
        include 'config/config_sql.php'; // Connexion à la base de données

        // Récupérer les messages
        $sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
        $stmt = $pdo->query($sql);
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<a href='admin_dashboard.php'>⬅️Retour au tableau de bord</a>";  // Lien retour au tableau de bord

        if (count($messages) === 0) {
        echo "<p>Aucun message trouvé.</p>";}
        else {
                echo "<h2>Messages reçus</h2>";
                echo "<table border='1'>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>";
                    foreach ($messages as $message) {
                    $isRead = $message['is_read'] ? 'Lu' : 'Non lu';
                    echo "<tr>";
                        echo "<td>" . htmlspecialchars($message['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($message['email']) . "</td>";
                            echo "<td>" . nl2br(htmlspecialchars($message['message'])) . "</td>";
                            echo "<td>" . htmlspecialchars($message['created_at']) . "</td>";
                            echo "<td>$isRead</td>";
                        echo "<td>";
                            if (!$message['is_read']) {
                            echo "<a href='mark_as_read.php?id=" . $message['id'] . "'>Marquer comme lu</a>";
                            } else {
                            echo "Déjà lu";
                            }
                        echo "</td>";
                    echo "</tr>";
                        }
                echo "</table>";
            }
    ?>
</body>
</html>
