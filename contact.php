<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact</title>
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
          <li class="nav-item"><a class="nav-link" href="services.php">SERVICES</a></li>
          <li class="nav-item"><a class="nav-link" href="habitats.php">HABITATS</a></li>
          <li class="nav-item"><a class="nav-link active" href="contact.php">CONTACT</a></li>
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

<body class="text-center">    
  <main class="form-signin container">
    <br><br><br><br><br><br><br><br>

    <?php
      // Inclure la configuration de la base de données
      include 'config/config_sql.php';

      // Vérification si le formulaire a été soumis
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupérer et assainir les données envoyées par l'utilisateur
      $name = trim($_POST['name']);
      $email = trim($_POST['email']);
      $message = trim($_POST['message']);

      // Vérification si les champs sont vides
      if (empty($name) || empty($email) || empty($message)) {
          echo '<span style="font-weight: bold; color: red; font-size: 24px;">Tous les champs sont obligatoires !</span>';
      }
      // Validation de l'email
      elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          echo '<span style="font-weight: bold; color: red; font-size: 24px;">L\'email que vous avez entré est invalide.</span>';
      } else {
          // Insertion du message dans la base de données
      try {
      // Requête préparée pour éviter les injections SQL
      $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
      $stmt->execute([$name, $email, $message]);

      // Affichage du message de succès
      echo '<span style="font-weight: bold; color: green; font-size: 24px;">Votre message a bien été envoyé. Merci de nous avoir contacté !</span>';
      } catch (PDOException $e) {
      // Gérer l'erreur en cas d'échec de la requête
      echo '<span style="font-weight: bold; color: red; font-size: 24px;">Une erreur est survenue. Veuillez réessayer plus tard.</span>';
      }
      }
      }
    ?>

    <form method="POST">
      <div class="text-center mb-4">
        <img class="mb-2" src="images/message.png" alt="" width="55" height="57">
        <h1 class="h3 mb-3 fw-normal">Nous contacter</h1>
        <h5>Si vous avez des questions ou des suggestions, n'hésitez pas à nous envoyer un message via ce formulaire.</h5>
      </div>
      <div class="mb-3 row align-items-center">
        <label for="name" class="col-sm-3 col-form-label text-end">Votre nom :</label>
        <div class="col-sm-9">
            <input type="text" id="name" name="name" class="form-control" required value="<?= htmlspecialchars($name ?? '') ?>">
        </div>
      </div>
      <div class="mb-3 row align-items-center">
        <label for="email" class="col-sm-3 col-form-label text-end">Votre E-mail :</label>
        <div class="col-sm-9">
            <input type="email" id="email" name="email" class="form-control" required value="<?= htmlspecialchars($email ?? '') ?>">
        </div>
      </div>
      <div class="mb-3 row align-items-top">
        <label for="message" class="col-sm-3 col-form-label text-end">Votre message :</label>
        <div class="col-sm-9">
            <textarea id="message" name="message" class="form-control" rows="5" required><?= htmlspecialchars($message ?? '') ?></textarea>
        </div>
      </div>
      <div class="text-center">
        <button class="btn btn-primary btn-lg" type="submit">Envoyer</button>
      </div>
    </form>


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
