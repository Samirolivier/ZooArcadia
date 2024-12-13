<?php
session_start();
include 'config/config_sql.php';
include 'config/mail_function.php';

// Connexion à MongoDB pour les services
require 'vendor/autoload.php'; // Bibliothèque MongoDB installé via Composer
$client = new MongoDB\Client("mongodb://localhost:27017"); // URL en local
$db = $client->zooarcadia; // Base de données MongoDB
$servicesCollection = $db->services; // Nom de la collection des services

// Vérifier si l'utilisateur est un administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('Location: connexion.php');
  exit();
}

// Récupérer le rôle de l'utilisateur pour l'affichage
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Inconnu';

// Création de comptes employés/vétérinaires
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    // Insérer un nouvel utilisateur dans la base de données SQL
    $stmt_create = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
    $stmt_create->execute([$email, $password, $role]);

    // Envoi de l'e-mail de notification à l'utilisateur
    $subject = "Création de votre compte sur le Zoo";
    $message = "Votre compte a été créé avec succès ! Email : $email";
    sendNotificationEmail($email, $subject, $message);

    echo "<p>Utilisateur créé avec succès et e-mail envoyé !</p>";
}

// Déconnexion
if (isset($_POST['logout'])) {
  session_destroy();
  header('Location: connexion.php');
  exit();
}
// Pagination des animaux
$animaux_par_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$debut = ($page - 1) * $animaux_par_page;

// Filtrage par habitat
$filter_habitat = isset($_GET['habitat_id']) ? $_GET['habitat_id'] : null;

// Récupération des services depuis MongoDB
$services = $servicesCollection->find()->toArray();

// Récupération des habitats depuis MySQL
$stmt_habitats = $pdo->prepare("SELECT * FROM habitats");
$stmt_habitats->execute();
$habitats = $stmt_habitats->fetchAll(PDO::FETCH_ASSOC) ?: [];

// Récupération des animaux avec pagination et filtre par habitat
$sql_animals = "SELECT a.*, h.name as habitat 
                FROM animals a 
                JOIN habitats h ON a.habitat_id = h.id";

if ($filter_habitat) {
    $sql_animals .= " WHERE a.habitat_id = :habitat_id";
}

$sql_animals .= " LIMIT :debut, :animaux_par_page";
$stmt_animals = $pdo->prepare($sql_animals);

if ($filter_habitat) {
    $stmt_animals->bindParam(':habitat_id', $filter_habitat, PDO::PARAM_INT);
}

$stmt_animals->bindParam(':debut', $debut, PDO::PARAM_INT);
$stmt_animals->bindParam(':animaux_par_page', $animaux_par_page, PDO::PARAM_INT);
$stmt_animals->execute();
$animals = $stmt_animals->fetchAll(PDO::FETCH_ASSOC);

// Calculer le nombre total d'animaux pour la pagination
$sql_total_animals = "SELECT COUNT(*) FROM animals";
if ($filter_habitat) {
    $sql_total_animals .= " WHERE habitat_id = :habitat_id";
}
$stmt_total_animals = $pdo->prepare($sql_total_animals);

if ($filter_habitat) {
    $stmt_total_animals->bindParam(':habitat_id', $filter_habitat, PDO::PARAM_INT);
}

$stmt_total_animals->execute();
$total_animals = $stmt_total_animals->fetchColumn();
$total_pages = ceil($total_animals / $animaux_par_page);

// Récupérer les comptes rendus des vétérinaires avec filtre par animal
$filter_animal = isset($_GET['animal_id']) ? $_GET['animal_id'] : null;
$sql_reports = "SELECT r.id, u.email as veterinarian, a.name as animal, r.report_date, r.description 
                FROM reports r 
                JOIN users u ON r.veterinarian_id = u.id
                JOIN animals a ON r.animal_id = a.id";

if ($filter_animal) {
    $sql_reports .= " WHERE r.animal_id = :animal_id";
}

$stmt_reports = $pdo->prepare($sql_reports);

if ($filter_animal) {
    $stmt_reports->bindParam(':animal_id', $filter_animal, PDO::PARAM_INT);
}

$stmt_reports->execute();
$reports = $stmt_reports->fetchAll(PDO::FETCH_ASSOC);

$stmt_all_animals = $pdo->prepare("SELECT id, name FROM animals ORDER BY name ASC"); // par ordre alphabétique
$stmt_all_animals->execute();
$all_animals = $stmt_all_animals->fetchAll(PDO::FETCH_ASSOC);

// Gestion des statistiques : nombre de consultations par animal
$stmt_stats = $pdo->prepare("SELECT a.name, COUNT(r.id) AS consultation_count 
                             FROM reports r 
                             JOIN animals a ON r.animal_id = a.id 
                             GROUP BY a.name");
$stmt_stats->execute();
$stats = $stmt_stats->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="dashboard1/style.css">
</head>
<body>
    <div class="header">
        <p>Bienvenue, <?= htmlspecialchars($role); ?></p>
        <form method="POST" action="admin_dashboard.php">
            <button type="submit" name="logout" class="logout-btn">Se Déconnecter</button>
        </form>
    </div>
    <h1>Tableau de Bord Administrateur</h1>
    <!-- Section pour créer un utilisateur -->
    <h2>Création d'un compte employé ou vétérinaire</h2>
    <form method="POST" action="admin_dashboard.php">
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>

        <label for="role">Rôle :</label>
        <select name="role" id="role" required>
            <option value="employe">Employé</option>
            <option value="veterinaire">Vétérinaire</option>
        </select>

        <button type="submit" name="create_user">Créer le compte</button>
    </form>

    <!-- Section pour gérer les services -->
    <h2>Gestion des Services</h2>
    <a href="edit_service.php">Ajouter un Service</a>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Contenu</th> <!-- Nouvelle colonne pour le contenu -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td>
                        <img src="<?= htmlspecialchars($service['image']); ?>" 
                            alt="<?= htmlspecialchars($service['name']); ?>" 
                            width="100">
                    </td>
                    <td><?= htmlspecialchars($service['name']); ?></td>
                    <td><?= htmlspecialchars($service['description']); ?></td>
                    <td>
                        <?= htmlspecialchars(mb_strimwidth($service['content'] ?? 'Pas de contenu', 0, 100, '...')); ?> 
                        <!-- Affiche les 100 premiers caractères -->
                    </td>
                    <td>
                        <a href="edit_service.php?id=<?= (string)$service['_id']; ?>">Modifier</a> |
                        <a href="delete_service.php?id=<?= (string)$service['_id']; ?>" 
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Section pour gérer les habitats -->
    <h2>Gestion des Habitats</h2>
    <a href="edit_habitat.php">Ajouter un Habitat</a>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Contenu</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($habitats)): ?>
                <?php foreach ($habitats as $habitat): ?>
                    <tr>
                        <td>
                            <?php if (!empty($habitat['image'])): ?>
                            <img src="<?= htmlspecialchars($habitat['image']); ?>" alt="<?= htmlspecialchars($habitat['name']); ?>" width="100">
                            <?php else: ?>
                            <p>Pas d'image</p>
                            <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($habitat['name']); ?></td>
                            <td><?= htmlspecialchars($habitat['description']); ?></td>
                            <td>
                                <?php
                                if (!empty($habitat['content'])) {
                                echo htmlspecialchars($habitat['content']); // Affiche le contenu complet
                                } else {
                                echo "<em>Pas de contenu disponible.</em>"; // Message explicite si aucun contenu
                                }
                                ?>
                            </td>
                            <td>
                            <a href="edit_habitat.php?id=<?= $habitat['id']; ?>">Modifier</a> |
                            <a href="delete_habitat.php?id=<?= $habitat['id']; ?>" 
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet habitat ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5">Aucun habitat trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Section pour gérer les animaux -->
    <h2>Liste des Animaux</h2>
    <a href="add_animal.php">Ajouter un Animal</a>
    <form method="GET" action="admin_dashboard.php">
        <label for="habitat">Filtrer par habitat :</label>
        <select name="habitat_id" id="habitat">
            <option value="">Tous</option>
            <?php foreach ($habitats as $habitat): ?>
            <option value="<?= $habitat['id']; ?>" <?= $filter_habitat == $habitat['id'] ? 'selected' : ''; ?>><?= $habitat['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrer</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Habitat</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($animals as $animal): ?>
            <tr>
                <td><?= htmlspecialchars($animal['name']); ?></td>
                <td><?= htmlspecialchars($animal['habitat']); ?></td>
                <td>
                    <a href="edit_animal.php?id=<?= $animal['id']; ?>">Modifier</a> |
                    <a href="delete_animal.php?id=<?= $animal['id']; ?>"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet animal ? Cette action est irréversible.')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i; ?>&habitat_id=<?= $filter_habitat; ?>" <?= $i == $page ? 'style="font-weight:bold;"' : ''; ?>>
            <?= $i; ?>
        </a>
        <?php endfor; ?>
    </div>

    <!-- Section pour afficher les comptes rendus des vétérinaires -->
    <h2>Comptes rendus des vétérinaires</h2>
    <form method="GET" action="admin_dashboard.php">
        <label for="animal_id">Filtrer par animal :</label>
        <select name="animal_id" id="animal_id">
            <option value="">Tous</option>
            <?php foreach ($all_animals as $animal): ?>
                <option value="<?= $animal['id']; ?>" <?= $filter_animal == $animal['id'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($animal['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrer</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Vétérinaire</th>
                <th>Animal</th>
                <th>Date</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?= htmlspecialchars($report['veterinarian']); ?></td>
                    <td><?= htmlspecialchars($report['animal']); ?></td>
                    <td><?= htmlspecialchars($report['report_date']); ?></td>
                    <td><?= htmlspecialchars($report['description']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Section pour afficher les statistiques -->
    <h2>Statistiques de Consultation des Animaux</h2>
    <table>
        <thead>
            <tr>
                <th>Animal</th>
                <th>Nombre de Consultations</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stats as $stat): ?>
                <tr>
                    <td><?= htmlspecialchars($stat['name']); ?></td>
                    <td><?= htmlspecialchars($stat['consultation_count']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    // Récupérer le nombre de messages non lus
    $sql = "SELECT COUNT(*) FROM contact_messages WHERE is_read = FALSE";
    $stmt = $pdo->query($sql);
    $unreadMessages = $stmt->fetchColumn();

    // Afficher la notification des messages non lus
    echo "<p>Vous avez $unreadMessages message(s) non lu(s). <a href='admin_messages.php'>Voir les messages</a></p>";
    ?>
</body>
</html>
