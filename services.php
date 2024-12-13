<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Services</title>


    <!-- Bootstrap core CSS -->
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img class="logo" src="accueil/logo-arcadia-zoo-3-1.png" alt="Logo Arcadia" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item"><a class="nav-link" href="index.php">ACCUEIL</a></li>
          <li class="nav-item"><a class="nav-link active" href="services.php">SERVICES</a></li>
          <li class="nav-item"><a class="nav-link" href="habitats.php">HABITATS</a></li>
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
      <br>
      </br>
      <br>
      </br>
      <h1 class="display-4 fst-italic">Nos Services</h1>
      <p class="lead my-3">Le Zoo Arcadia est ouvert toute l'année, offrant une aventure inoubliable pour toute la famille. Venez découvrir nos services et participer à nos animations quotidiennes..</p>
    </div>
  </div>
<div class="row g-5">
  <div class="col-md-8">
  <?php
include 'config/config_nosql.php'; // Inclure la configuration MongoDB

try {
    // Accéder à la collection services
    $collection = $mongoDB->zooarcadia->services;

    // Récupérer les documents de la collection
    $services = $collection->find([], ['sort' => ['name' => 1]])->toArray();

    // Vérifier si des services existent
    if (!empty($services)) {
        $index = 0; // Compteur pour alterner les positions
        foreach ($services as $service) {
            // Vérifier si l'index est pair ou impair pour définir la disposition
            $isImageLeft = $index % 2 !== 0; // Alterner image à gauche/texte à droite

            echo '<div class="col-12 mb-4">'; // Chaque service sur une ligne
            echo '<div class="row g-0 border rounded overflow-hidden flex-md-row shadow-sm h-md-250 position-relative">';

            if ($isImageLeft) {
                // Image à gauche
                if (isset($service['image']) && !empty($service['image'])) {
                    // Utiliser le chemin complet tel qu'il est enregistré dans la base de données
                    $imagePath = '' . htmlspecialchars($service["image"]);
                    echo '<div class="col-auto d-lg-block text-center">';
                    echo '<img src="' . $imagePath . '" alt="Image de ' . htmlspecialchars($service['name']) . '" 
                          class="bd-placeholder-img rounded-circle mb-3" style="width: 250px; height: 250px; object-fit: cover;">';
                    echo '</div>';
                } else {
                    echo '<div class="col-auto d-lg-block text-center">';
                    echo '<img src="http://via.placeholder.com/150" alt="Image indisponible" 
                          class="bd-placeholder-img rounded-circle mb-3" style="width: 150px; height: 150px;object-fit: cover;">';
                    echo '</div>';
                }
            }

            // Colonne principale (texte)
            echo '<div class="col p-4 d-flex flex-column position-static">';
            echo '<h3 class="mb-0">' . htmlspecialchars($service['name']) . '</h3>';
            echo '<p class="card-text mb-auto">' .($service['description']) . '</p>';
            echo '<a href="service_detail.php?id=' . $service["_id"] . '" class="stretched-link">En savoir plus</a>';
            echo '</div>';

            if (!$isImageLeft) {
                // Image à droite
                if (isset($service['image']) && !empty($service['image'])) {
                    // Utiliser le chemin complet tel qu'il est enregistré dans la base de données
                    $imagePath = '' . htmlspecialchars($service["image"]);
                    echo '<div class="col-auto d-lg-block text-center">';
                    echo '<img src="' . $imagePath . '" alt="Image de ' . htmlspecialchars($service['name']) . '" 
                          class="bd-placeholder-img rounded-circle mb-3" style="width: 250px; height: 250px; object-fit: cover;">';
                    echo '</div>';
                } else {
                    echo '<div class="col-auto d-lg-block text-center">';
                    echo '<img src="http://via.placeholder.com/150" alt="Image indisponible" 
                          class="bd-placeholder-img rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">';
                    echo '</div>';
                }
            }

            echo '</div>';
            echo '</div>';

            $index++; // Incrémenter le compteur pour alterner
        }
    } else {
        echo '<p class="text-center">Aucun service disponible pour le moment.</p>';
    }
} catch (Exception $e) {
    echo "<p class='text-danger'>Erreur lors de l'accès à MongoDB : " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>


</div>

<div class="col-md-4">
    <div class="p-4 mb-3 bg-light rounded">
      <h4 class="fst-italic">A propos de nous</h4>
      <p class="mb-0">Bienvenue au Zoo Arcadia un havre de paix situé en plein cœur de la Bretagne, à proximité de la légendaire forêt de Brocéliande. Nous vous invitons à découvrir la beauté et la diversité du monde animal dans un cadre naturel et préservé. Un Voyage au Cœur de la nature dans les différents habitats du globe. </p>
    </div>

    <div class="p-4">
    <h4 class="fst-italic">Nos Services</h4>
    <ol class="list-unstyled">
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
    </ol>
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
      <ol class="list-unstyled">
        <li><a href="#">GitHub</a></li>
        <li><a href="#">Twitter</a></li>
        <li><a href="#">Facebook</a></li>
      </ol>
    </div>
  </div>
</div>
</div>
</div>
</div>

</main>

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
