<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Description habitat</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Style général pour le modal */
        #animalModal .modal-content {
        background: #fff;
        padding: 20px;
        margin: 10% auto;
        width: 90%;
        max-width: 600px;
        border-radius: 10px;
        position: relative;
        box-sizing: border-box;
        }

        #animalModal .modal-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 15px;
        object-fit: cover;
        }

        #animalModal .close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 30px;
        font-weight: bold;
        color: #333;
        cursor: pointer;
        }

        /* Media Queries pour différents écrans */
        @media (max-width: 768px) {
        #animalModal .modal-content {
            width: 95%;
            margin: 5% auto;
        }

        #animalModal .close {
            top: 10px;
            right: 10px;
            font-size: 28px;
        }

        #animalModal .modal-content h2 {
            font-size: 1.5em;
        }
        }

        @media (max-width: 480px) {
        #animalModal .modal-content {
            width: 100%;
            padding: 15px;
        }

        #animalModal .close {
            top: 5px;
            right: 5px;
            font-size: 26px;
        }

        #animalModal .modal-content h2 {
            font-size: 1.2em;
        }

        #animalModal .modal-content p {
            font-size: 14px;
        }
        }
    </style>


</head>

<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img class="logo" src="/accueil/logo-arcadia-zoo-3-1.png" alt="Logo Arcadia" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">ACCUEIL</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">SERVICES</a></li>
                    <li class="nav-item"><a class="nav-link active" href="habitats.php">HABITATS</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">CONTACT</a></li>
                    <li class="nav-item"><a class="nav-link" href="connexion.php">CONNEXION</a></li>
                </ul>

                <div style="margin: 10px; font-family: Arial, sans-serif; color: white; font-size: 12px;">
                    <a style="margin: 30px; font-family: Arial, sans-serif; color: black; font-size: 14px;"><b><u>Nous joindre:</u></b></a>
                    <div style="margin-bottom: 2px;">
                        <strong style="font-weight: bold; color: white; margin-right: 20px;">Téléphone : 06 80 00 00 00</strong>
                    </div>
                    <div style="margin-bottom: 2px;">
                        <strong style="font-weight: bold; color: white; margin-right: 20px;">Adresse : forêt de Brocéliande, Bretagne</strong>
                    </div>
                    <div style="margin-bottom: 2px;">
                        <strong style="font-weight: bold; color: white;">Email : contact@zooarcadia.fr</strong>
                    </div>
                </div>

            </div>
        </div>
    </nav>
</header>

<body>    
    <main class="container">
        <div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
            <div class="col-md-6 px-0">
                <br></br>
                <br></br>
                <h1 class="display-4 fst-italic">Nos Habitats</h1>
                <p class="lead my-3">Zoo Arcadia met un point d'honneur à assurer la santé et le bien-être de ses animaux. Nos équipes de vétérinaires et d'employeurs dédiés travaillent sans relâche pour offrir les meilleurs soins possibles. Chaque habitat est conçu pour répondre aux besoins spécifiques des espèces qu'il accueille, garantissant ainsi leur confort et leur épanouissement.</p>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-md-8">
                <?php
                    include 'config/config_sql.php'; // Inclure la configuration SQL
                    include 'config/config_nosql.php'; // Inclure la configuration MongoDB

                    $id = isset($_GET['id']) ? $_GET['id'] : 0; // Vérifie la présence de 'id'

                    if ($id) {
                    // Récupérer les détails de l'animal depuis SQL
                    $stmt_habitats = $pdo->prepare("SELECT * FROM habitats WHERE id = ?");
                    $stmt_habitats->execute([$id]);
                    $habitat = $stmt_habitats->fetch(PDO::FETCH_ASSOC);

                    if ($habitat) {
                    $stmt = $pdo->prepare("SELECT * FROM animals WHERE habitat_id = ?");
                    $stmt->execute([$id]);
                    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    } else {
                    echo json_encode(['error' => 'Habitat non trouvé']);
                    }
                    } else {
                    echo json_encode(['error' => 'ID non fourni']);
                    }

                    if (isset($_GET['id'])) {
                    $habitatId = $_GET['id']; // Récupérer l'ID depuis l'URL
                    $source = $_GET['source'] ?? 'sql'; // Déterminer la source (sql ou mongodb)

                    try {
                    if ($source === 'mongodb') {
                    // Si la source est MongoDB
                    $collection = $mongoDB->zooarcadia->habitats;

                    // Rechercher par _id dans MongoDB
                    $habitat = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($habitatId)]);

                    if ($habitat) {
                    // Afficher les données
                    echo '<h1>' . htmlspecialchars($habitat['name']) . '</h1>';
                    if (!empty($habitat['image'])) {
                    $imagePath = '' . htmlspecialchars($habitat['image']);
                    echo '<img src="' . $imagePath . '" alt="Image de ' . htmlspecialchars($habitat['name']) . '" 
                          style="max-width: 100%; border-radius: 10px;">';
                    } else {
                    echo '<img src="http://via.placeholder.com/800x400" alt="Image indisponible" style="max-width: 100%; border-radius: 10px;">';
                    }
                    echo '<p>' . htmlspecialchars($habitat['description']) . '</p>';
                    echo '<div>' . ($habitat['content'] ?? 'Aucune information détaillée disponible.') . '</div>';
                    } else {
                    echo '<p class="text-danger">Habitat non trouvé dans MongoDB.</p>';
                    }
                    } elseif ($source === 'sql') {
                    // Si la source est SQL
                    $stmt = $pdo->prepare("SELECT * FROM habitats WHERE id = :id");
                    $stmt->bindParam(':id', $habitatId, PDO::PARAM_INT);
                    $stmt->execute();
                    $habitat = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($habitat) {
                    // Afficher les données
                    echo '<h1>' . htmlspecialchars($habitat['name']) . '</h1>';
                    if (!empty($habitat['image'])) {
                    // Construire le chemin de l'image pour SQL
                    $imagePath = '' . htmlspecialchars($habitat['image']);
                    echo '<img src="' . $imagePath . '" alt="Image de ' . htmlspecialchars($habitat['name']) . '" 
                          style="max-width: 100%; border-radius: 10px;">';
                    } else {
                    echo '<img src="http://via.placeholder.com/800x400" alt="Image indisponible" style="max-width: 100%; border-radius: 10px;">';
                    }
                    echo '<p>' . htmlspecialchars_decode($habitat['description']) . '</p>';
                    echo '<div>' . htmlspecialchars_decode($habitat['content'] ?? 'Aucune information détaillée disponible.') . '</div>';
                    } else {
                    echo '<p class="text-danger">Habitat non trouvé dans SQL.</p>';
                    }
                    } else {
                    echo '<p class="text-danger">Source inconnue.</p>';
                    }
                    } catch (Exception $e) {
                    echo '<p class="text-danger">Erreur : ' . htmlspecialchars($e->getMessage()) . '</p>';
                    }
                    } else {
                    echo '<p class="text-warning">Aucun habitat sélectionné.</p>';
                    }
                ?>

                <br></br>
                <h4><u>Les animaux présents dans cet habitat</u></h4>
                <ul>
                    <div class="row g-4">
                        <?php if (isset($animals) && is_array($animals) && count($animals) > 0): ?>
                        <?php foreach ($animals as $animal): ?>
                            <div class="col-md-3 col-sm-6 text-center mb-4">
                                <div class="animal-item p-2" onclick="openModal('<?php echo htmlspecialchars($animal['id']); ?>')" style="cursor: pointer; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                                    <img src="<?php echo htmlspecialchars($animal['image']); ?>" 
                                    alt="<?php echo htmlspecialchars($animal['name']); ?>" 
                                    class="img-fluid rounded mb-2" 
                                    style="height: 150px; object-fit: cover; border-radius: 10px;">
                                    <h5 class="mt-2" style="color: #333;"><?php echo htmlspecialchars($animal['name']); ?></h5>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p>Aucun animal trouvé dans cet habitat.</p>
                        <?php endif; ?>
                    </div>
                </ul>

                <!-- Modal -->
                <div id="animalModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000;">
                    <div class="modal-content" style="background: #fff; padding: 20px; margin: 10% auto; width: 90%; max-width: 600px; border-radius: 10px; position: relative; box-sizing: border-box;">
                        <span class="close" onclick="closeModal()" style="position: absolute; top: -10px; right: 15px; font-size: 30px; font-weight: bold; color: #333; cursor: pointer;">&times;</span>
                        <img id="modalImage" src="" alt="" style="max-width: 100%; height: auto; border-radius: 8px; margin-bottom: 15px; object-fit: cover;">
                        <h2 id="modalName" style="text-align: center; margin-bottom: 15px;"></h2>
                        <p id="modalFood"></p>
                        <p id="modalWeight"></p>
                        <p id="modalHealthStatus"></p>
                        <p id="modalViews"></p>
                    </div>
                </div>

                <script>
                    function openModal(animalId) {
                    // Effectuer une requête pour récupérer les détails de l'animal
                    fetch('get_animal_details.php?id=' + animalId)
                    .then(response => {
                    if (!response.ok) {
                    throw new Error('Erreur HTTP : ' + response.status);
                    }
                    return response.json();
                    })
                    .then(data => {
                    if (data.error) {
                    console.error('Erreur API :', data.error);
                    return;
                    }

                    // Mettre à jour les informations du modal
                    document.getElementById('modalImage').src = data.image || 'placeholder.jpg';
                    document.getElementById('modalName').textContent = data.name || 'Nom non disponible';
                    document.getElementById('modalFood').textContent = 'Nourriture donnée : ' + (data.food || 'Non disponible');
                    document.getElementById('modalWeight').textContent = 'Grammage : ' + (data.weight || 'Non disponible') + ' g';
                    document.getElementById('modalHealthStatus').textContent = 'État de santé : ' + (data.health_status || 'Non disponible');
                    document.getElementById('modalViews').textContent = 'Nombre de vues : ' + (data.views || '0');

                    // Afficher le modal
                    document.getElementById('animalModal').style.display = 'block';
                    })
                    .catch(error => {
                    console.error('Erreur lors de la récupération des détails de l\'animal :', error);
                    });
                    }

                    // Fermer le modal
                    function closeModal() {
                    document.getElementById('animalModal').style.display = 'none';
                    }

                    // Fermer le modal si on clique à l'extérieur
                    window.onclick = function (event) {
                    if (event.target == document.getElementById('animalModal')) {
                    closeModal();
                    }
                    };
                </script>


            </div>

            <div class="col-md-4">

                <div class="p-4 mb-3 bg-light rounded">
                <h4 class="fst-italic">A propos de nous</h4>
                <p class="mb-0">Bienvenue au Zoo Arcadia un havre de paix situé en plein cœur de la Bretagne, à proximité de la légendaire forêt de Brocéliande. Nous vous invitons à découvrir la beauté et la diversité du monde animal dans un cadre naturel et préservé. Un Voyage au Cœur de la nature dans les différents habitats du globe. </p>
            </div>

            <div class="p-4">
                <h4 class="fst-italic">Nos Services</h4>
                <div class="list-unstyled">
                    <?php
                        include 'config/config_nosql.php'; // Inclure la configuration MongoDB

                        try {
                        // Accéder à la collection services
                        $collection = $mongoDB->zooarcadia->services;

                        // Récupérer les documents de la collection
                        $services = $collection->find([], ['sort' => ['name' => 1]])->toArray();

                        // Vérifier si des services existent
                        if (!empty($services)) {
                        foreach ($services as $service) {
                        echo '<li>';
                        echo '<a href="service_detail.php?id=' . htmlspecialchars($service['_id']) . '">' . htmlspecialchars($service['name']) . '</a>';
                        echo '</li>';
                        }
                        } else {
                        echo '<p>Aucun service disponible pour le moment.</p>';
                        }
                        } catch (Exception $e) {
                        echo '<p class="text-danger">Erreur lors de l\'accès à MongoDB : ' . htmlspecialchars($e->getMessage()) . '</p>';
                        }
                    ?>
                </div>

            </div>

            <div class="p-4">
                <h4 class="fst-italic">Nos Habitats</h4>
                <ul class="list-unstyled">
                    <?php
                        include 'config/config_sql.php'; // Inclure la configuration SQL

                        try {
                        // Préparer et exécuter la requête pour récupérer les habitats
                        $stmt = $pdo->prepare("SELECT id, name FROM habitats ORDER BY name ASC");
                        $stmt->execute();

                        // Récupérer les résultats
                        $habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Vérifier si des habitats existent
                        if (!empty($habitats)) {
                        foreach ($habitats as $habitat) {
                        echo '<li>';
                
                        // Créer un lien dynamique vers la page de détails
                        echo '<a href="habitat_detail.php?id=' . htmlspecialchars($habitat['id']) . '">' . htmlspecialchars($habitat['name']) . '</a>';
                
                        echo '</li>';
                        }
                        } else {
                        echo '<p>Aucun habitat disponible pour le moment.</p>';
                        }
                        } catch (Exception $e) {
                        echo '<p class="text-danger">Erreur lors de l\'accès à la base de données : ' . htmlspecialchars($e->getMessage()) . '</p>';
                        }
                                        
                    ?>
                </ul>
            </div>
            <div class="p-4">
                <h4 class="fst-italic">Nous suivre</h4>
                <div class="list-unstyled">
                    <li><a href="#">GitHub</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Facebook</a></li>
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <footer class="container section-spacing">
            <p class="float-end"><a href="#">Retour en haut</a></p>
            <p style="text-align: center;">&copy; 2024 développé par amour par <a href="https://mapluscorporate.com/" target="_blank">DevSoft,</a>Inc. &middot; <a href="mentions_legales.php">Mentions légales</a> &middot; <a href="loi_rgpd.php">Loi RGPD</a></p>
        </footer>
    </main>
    <!-- JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>