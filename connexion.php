<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion</title>
  <!-- Bootstrap CSS -->
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
          <li class="nav-item"><a class="nav-link" href="contact.php">CONTACT</a></li>
          <li class="nav-item"><a class="nav-link active" href="connexion.php">CONNEXION</a></li>
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

    <div class="text-center mb-4">
      <img class="mb-2" src="images/connexion.png" alt="Connexion" width="55" height="57">
      <h1 class="h3 mb-3 fw-normal">Identifiez-vous</h1>
    </div>

    <!-- Formulaire de connexion -->
    <form id="loginForm">
      <div class="mb-3 row align-items-center">
        <label for="email" class="col-sm-4 col-form-label text-end">Votre adresse Email :</label>
        <div class="col-sm-8">
          <input type="email" id="email" name="email" class="form-control" required>
        </div>
      </div>

      <div class="mb-3 row align-items-center">
        <label for="password" class="col-sm-4 col-form-label text-end">Mot de passe :</label>
        <div class="col-sm-8">
          <input type="password" id="password" name="password" class="form-control" required>
        </div>
      </div>

      <div class="mb-3 row align-items-center">
        <div class="offset-sm-4 col-sm-8 d-flex align-items-center">
          <input class="form-check-input me-2" type="checkbox" id="rememberMe" value="remember-me">
          <label class="form-check-label" for="rememberMe">Se rappeler de moi</label>
        </div>
      </div>

      <div class="text-center">
        <button class="btn btn-primary btn-lg" type="submit">Connexion</button>
      </div>
    </form>

    <!-- Zone pour afficher les messages -->
    <div id="message" class="mt-3"></div>

    <!-- FOOTER -->
    <footer class="container section-spacing">
      <p class="float-end"><a href="#">Retour en haut</a></p>
      <p style="text-align: center;">&copy; 2024 développé par amour par <a href="https://mapluscorporate.com/" target="_blank">DevSoft,</a>Inc. &middot; <a href="mentions_legales.php">Mentions légales</a> &middot; <a href="loi_rgpd.php">Loi RGPD</a></p>
    </footer>
  </main>

  <!-- JavaScript Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script Fetch/AJAX -->
  <script>
    document.getElementById('loginForm').addEventListener('submit', async function (e) {
      e.preventDefault(); // Empêche le rechargement de la page

      // Récupérer les données du formulaire
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      // Zone pour afficher les messages
      const messageDiv = document.getElementById('message');
      messageDiv.innerHTML = ''; // Réinitialise les messages précédents

      try {
        // Envoyer les données via fetch
        const response = await fetch('login.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ email, password })
        });

        const result = await response.json();

        if (result.success) {
          // Redirection en fonction du rôle
          if (result.role === 'admin') {
            window.location.href = 'admin_dashboard.php';
          } else if (result.role === 'employe') {
            window.location.href = 'employe_dashboard.php';
          } else if (result.role === 'veterinaire') {
            window.location.href = 'vet_dashboard.php';
          } else {
            messageDiv.innerHTML = '<div class="alert alert-warning">Rôle inconnu. Veuillez contacter l\'administrateur.</div>';
          }
        } else {
          // Afficher un message d'erreur
          messageDiv.innerHTML = `<div class="alert alert-danger">${result.message || 'Une erreur est survenue.'}</div>`;
        }
      } catch (error) {
        console.error('Erreur lors de la requête:', error);
        messageDiv.innerHTML = '<div class="alert alert-danger">Impossible de traiter la requête. Veuillez réessayer plus tard.</div>';
      }
    });
  </script>
</body>
</html>
