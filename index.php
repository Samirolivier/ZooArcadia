<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Accueil</title>

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
          <li class="nav-item"><a class="nav-link active" href="index.php">ACCUEIL</a></li>
          <li class="nav-item"><a class="nav-link" href="services.php">SERVICES</a></li>
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

<main>
  <!-- Slide-->
  <div id="simpleCarousel" class="carousel slide section-spacing" data-bs-ride="carousel"> 
    <div class="carousel-inner"> 
      <!-- Slide 1 -->
      <div class="carousel-item active">
        <img src="images/pampas-rabbits-3502921_1920.jpg" class="d-block w-100" alt="Slide 1">
        <div class="carousel-caption d-none d-md-block">
        <h1 style="text-align: left;">Découvrez nos Merveilles Exotiques</h1>
        <p><h2 style="text-align: left;">Rencontrez des espèces uniques venues des quatre coins du monde : girafes, tigres du Bengale, et bien plus encore !</h2></p>
      </div>
    </div>
    <!-- Slide 2 -->
    <div class="carousel-item">
        <img src="images/giraffe-2222908_1920.jpg" class="d-block w-100" alt="Slide 2">
        <div class="carousel-caption d-none d-md-block">
          <h1>Vivez une Expérience Immersive</h1>
          <p><h2>Parcourez nos espaces interactifs pour observer les animaux au plus près dans leur environnement naturel recréé.</h2></p>
        </div>
    </div>
    <!-- Slide 3 -->
    <div class="carousel-item">
      <img src="images/penguin-8751952_1920.jpg" class="d-block w-100" alt="Slide 2">
      <div class="carousel-caption d-none d-md-block">
        <h1>Des Activités pour Toute la Famille</h1>
        <p><h2>Ateliers, spectacles animaliers et aires de jeux pour faire de votre visite un moment inoubliable.</h2></p>
      </div>
    </div>
    <!-- Slide 4 -->
    <div class="carousel-item">
      <img src="images/monkey-4360298_1920.jpg" class="d-block w-100" alt="Slide 3">
      <div class="carousel-caption d-none d-md-block">
        <h1>Des Événements Magiques Vous Attendent</h1>
        <p><h2>Ne manquez pas nos nocturnes, anniversaires animaliers et expériences VIP pour un moment unique au Zoo Arcadia.</h2></p>
      </div>
    </div>
  </div>
  <!-- Contrôles de navigation -->
  <button class="carousel-control-prev" type="button" data-bs-target="#simpleCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Précédent</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#simpleCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Suivant</span>
  </button>
  <!-- Services -->
  <main class="container">
    <div class="bg-light p-5 rounded mt-3">
      <h2 style="text-align: center;">
        <a href="services.php" style="animation: blink 1s infinite; text-decoration: none; display: inline-block;">Nos Services</a>
      </h2>
      <div class="container marketing section-spacing">
        <div class="row justify-content-center">
          <?php
            include 'config/config_nosql.php'; // Inclure la configuration MongoDB

            // Vérifier si $mongoDB est défini
            if (!isset($mongoDB)) {
            die("MongoDB n'est pas configuré correctement.");
            }

            try {
            // Accéder à la base zooarcadia et la collection services
            $collection = $mongoDB->zooarcadia->services;

            // Récupérer tous les documents dans la collection "services" et les convertir en tableau
            $services = $collection->find()->toArray(); // Convertir le curseur en tableau

            // Vérifier si des services existent
            if (!empty($services)) {
            foreach ($services as $service) {
            // Construire le chemin de l'image
            $imageField = htmlspecialchars($service["image"] ?? ''); // Champ 'image' depuis MongoDB
            $imagePath = (strpos($imageField, 'images/images/services') === false) 
            ? 'images/images/services' . $imageField 
            : '' . $imageField; // Si le champ contient déjà le chemin complet

            echo '<div class="col-lg-4 d-flex flex-column align-items-center text-center mb-4">';
            
            // Image du service
            if (!empty($imageField)) {
                echo '<img src="' . $imagePath . '" class="bd-placeholder-img rounded-circle mb-3" width="220" height="220" alt="' . htmlspecialchars($service["name"] ?? 'Service') . '">';
            } else {
                echo '<img src="http://via.placeholder.com/140x140" class="bd-placeholder-img rounded-circle mb-3" alt="Image indisponible">';
            }

            // Nom du service
            echo '<h2>' . htmlspecialchars($service["name"] ?? 'Nom non défini') . '</h2>';
            
            // Description du service
            echo '<p>' .($service["description"] ?? 'Description non disponible') . '</p>';
            
            // Bouton de détail
            echo '<p><a class="btn btn-secondary" href="service_detail.php?id=' . htmlspecialchars((string)$service["_id"]) . '">Voir détail &raquo;</a></p>';
            
            echo '</div>';
            }
            } else {
            echo "<p>Aucun service trouvé.</p>";
            }
            } catch (Exception $e) {
            echo "Erreur lors de l'accès à MongoDB : " . $e->getMessage();
            }
          ?>
        </div>
      </div>
    </div>

    <!-- Habitats -->
    <main class="container">
      <div class="bg-light p-5 rounded mt-3">
        <h2 style="text-align: center;">
          <a href="habitats.php" style="animation: blink 1s infinite; text-decoration: none; display: inline-block;">Nos Habitats</a>
        </h2>
        <div class="container marketing section-spacing">
          <div class="row justify-content-center">
            <?php
              include 'config/config_sql.php'; // Inclure la configuration SQL

              try {
              // Préparer une requête pour récupérer tous les habitats
              $stmt = $pdo->prepare("SELECT * FROM habitats ORDER BY id ASC");
              $stmt->execute();

              // Récupérer les résultats
              $habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

              // Vérifier si des habitats existent
              if (!empty($habitats)) {
              $counter = 0;
              foreach ($habitats as $habitat) {
              $counter++;
              echo '<hr class="featurette-divider">';
            
              // Ajouter la classe px-md-5 pour un espacement horizontal symétrique sur les grands écrans
              echo '<div class="row featurette px-4 px-md-5 align-items-center">';

              // Préparer le chemin de l'image
              $imageField = htmlspecialchars($habitat["image"] ?? ''); // Champ 'image' depuis SQL
              $imagePath = (strpos($imageField, 'images/images/habitats') === false) 
              ? 'images/images/habitats/' . $imageField 
              : $imageField; // Utilise directement si déjà complet

              // Alternance des positions (texte à gauche, image à droite ou inversement)
              if ($counter % 2 == 0) {
              // Habitat pair : Texte à droite, image à gauche
              echo '<div class="col-md-7 order-md-2">';
              echo '<h2 class="featurette-heading">' . htmlspecialchars($habitat["name"]) . '</h2>';
              echo '<p class="lead">' .($habitat["description"]) . '</p>';
              echo '<p><a class="btn btn-secondary" href="habitat_detail.php?id=' . $habitat["id"] . '&source=sql">Voir détail &raquo;</a></p>';
              echo '</div>';
              echo '<div class="col-md-5 order-md-1">';
              echo '<img src="' . $imagePath . '" class="featurette-image img-fluid mx-auto rounded" alt="' . htmlspecialchars($habitat["name"]) . '">';
              echo '</div>';
              } else {
              // Habitat impair : Texte à gauche, image à droite
              echo '<div class="col-md-7">';
              echo '<h2 class="featurette-heading">' . htmlspecialchars($habitat["name"]) . '</h2>';
              echo '<p class="lead">' .($habitat["description"]) . '</p>';
              echo '<p><a class="btn btn-secondary" href="habitat_detail.php?id=' . $habitat["id"] . '&source=sql">Voir détail &raquo;</a></p>';
              echo '</div>';
              echo '<div class="col-md-5">';
              echo '<img src="' . $imagePath . '" class="featurette-image img-fluid mx-auto rounded" alt="' . htmlspecialchars($habitat["name"]) . '">';
              echo '</div>';
              }

              echo '</div>'; // fin de la div row featurette
              }
              } else {
              echo "<p>Aucun habitat trouvé.</p>";
              }
              } catch (Exception $e) {
              echo "Erreur lors de l'accès à la base de données SQL : " . $e->getMessage();
              }
            ?>
          </div>
        </div>
      </div>
    </main>

    <br></br>

    <!-- Avis -->

    <main class="container">
      <div class="bg-light p-5 rounded mt-3">
        <h2 style="text-align: center; font-weight: bold;">Vos mots, notre plus belle récompense.</h2>

        <?php
          include 'config/config_nosql.php'; // Inclure la configuration MongoDB

          // Message de confirmation après la soumission d'un avis
          $confirmation_message = '';

          // Vérifier si le formulaire a été soumis
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $visitor_name = $_POST['visitor_name'] ?? '';
          $review_text = $_POST['review'] ?? '';

          // Validation des champs
          if (empty($visitor_name) || empty($review_text)) {
          $confirmation_message = 'Tous les champs sont obligatoires.';
          } else {
          try {
          // Accéder à la collection reviews
          $collection = $mongoDB->zooarcadia->reviews;

          // Insérer l'avis dans la base de données MongoDB
          $result = $collection->insertOne([
          'visitor_name' => $visitor_name,
          'review' => $review_text,
          'is_validated' => false,  // L'avis est en attente de validation
          'created_at' => new MongoDB\BSON\UTCDateTime() // Date de création
          ]);

          $confirmation_message = "Votre avis a été soumis avec succès et est en attente de validation.";
          } catch (Exception $e) {
          $confirmation_message = "Une erreur est survenue lors de l'envoi de votre avis : " . $e->getMessage();
          }
          }
          }

          try {
          // Récupérer les avis validés (is_validated => true)
          $collection = $mongoDB->zooarcadia->reviews;
          $reviews = $collection->find(['is_validated' => true], ['sort' => ['created_at' => -1]])->toArray();

          if (!empty($reviews)) {
          // Passer les avis validés à JavaScript
          echo '<script>';
          echo 'const reviews = ' . json_encode($reviews) . ';';
          echo '</script>';

          // Structure HTML pour afficher un seul avis à la fois
          echo '<div style="display: flex; align-items: center; justify-content: center; margin-top: 20px;">';
                
          // Flèche gauche
          echo '<button id="left-arrow" style="border: none; background: none; font-size: 24px; cursor: pointer; margin-right: 10px;">&#9664;</button>';
                
          // Conteneur pour l'avis affiché
          echo '<div id="review-container" style="padding: 20px; margin: 10px; background-color: #e9f7ef; border: 1px solid #d4edda; border-radius: 10px; max-width: 600px; text-align: center;">';
          echo '<h5 id="visitor-name" style="font-weight: bold; color: #155724; margin-bottom: 10px;"></h5>';
          echo '<p id="review-text" style="color: #155724; font-size: 16px; margin: 0;"></p>';
          echo '</div>';
                
          // Flèche droite
          echo '<button id="right-arrow" style="border: none; background: none; font-size: 24px; cursor: pointer; margin-left: 10px;">&#9654;</button>';
                
          echo '</div>';

          // JavaScript pour gérer le défilement des avis
          echo '<script>
          let currentIndex = 0;

          function showReview(index) {
          const visitorName = document.getElementById("visitor-name");
          const reviewText = document.getElementById("review-text");

          if (reviews.length > 0) {
          visitorName.textContent = reviews[index].visitor_name;
          reviewText.textContent = reviews[index].review;
          }
          }

          document.getElementById("left-arrow").addEventListener("click", function() {
          currentIndex = (currentIndex - 1 + reviews.length) % reviews.length;
          showReview(currentIndex);
          });

          document.getElementById("right-arrow").addEventListener("click", function() {
          currentIndex = (currentIndex + 1) % reviews.length;
          showReview(currentIndex);
          });

          // Afficher le premier avis au chargement
          document.addEventListener("DOMContentLoaded", function() {
          showReview(currentIndex);
          });
          </script>';
          } else {
          echo '<p style="text-align: center; font-size: 18px; color: #6c757d;">Aucun avis disponible pour le moment.</p>';
          }
          } catch (Exception $e) {
          echo '<p style="text-align: center; color: red;">Erreur lors de la récupération des avis : ' . htmlspecialchars($e->getMessage()) . '</p>';
          }
        ?>

        <!-- Affichage du message de confirmation si un avis a été soumis -->
        <?php if (!empty($confirmation_message)): ?>
            <div style="text-align: center; font-size: 18px; margin-bottom: 20px; color: #155724;">
                <p><strong><?= htmlspecialchars($confirmation_message); ?></strong></p>
            </div>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 40px;">
          <h4 style="font-weight: bold; margin-bottom: 20px;">Donnez votre avis</h4>
          <form action="" method="POST" style="max-width: 500px; margin: auto; background-color: #f8f9fa; padding: 20px; border-radius: 10px; border: 1px solid #ced4da;">
            <div style="margin-bottom: 15px;">
              <label for="visitor_name" style="display: block; font-weight: bold; margin-bottom: 5px;">Pseudo:</label>
              <input type="text" name="visitor_name" id="visitor_name" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px;">
            </div>
            <div style="margin-bottom: 20px;">
              <label for="review" style="display: block; font-weight: bold; margin-bottom: 5px;">Texte:</label>
              <textarea name="review" id="review" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; min-height: 100px;"></textarea>
            </div>
            <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Envoyer</button>
          </form>
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
