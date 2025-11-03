<?php
header('Content-Type: text/html; charset=utf-8');
$host = 'mysql';
$db   = 'db';
$user = 'user';
$pass = 'password';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $pdo->query("SELECT id, firstname, lastname, picture FROM users");
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CV Numériques 💼</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
  <script src="assets/js/script.js?v=<?php echo time(); ?>"></script>
  <style>
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
    }
  </style>
</head>

<body class="pink lighten-5">
  <nav class="pink darken-2 center-align">
    <div class="nav-wrapper">
      <span class="brand-title white-text">CV Numériques</span>
    </div>
  </nav>

  <main class="container section">
    <h4 class="pink-text text-darken-2 center-align">Bienvenue 👋</h4>
    <p class="grey-text text-darken-2 center-align">
      Découvrez nos parcours et compétences à travers nos CV numériques.<br>
      Choisissez la personne dont vous souhaitez consulter ou modifier le profil :
    </p>

    <div class="row">
      <?php foreach ($users as $user): ?>
        <div class="col s12 m6 l6 user-card">
          <div class="card hoverable">
            <div class="card-image">
              <img src="assets/img/<?= htmlspecialchars($user['picture']) ?>" alt="Photo de <?= htmlspecialchars($user['firstname']) ?>">
            </div>
            <div class="card-content">
              <span class="card-title pink-text text-darken-2">
                <?= htmlspecialchars($user['firstname']) ?> <?= htmlspecialchars($user['lastname']) ?>
              </span>
            </div>
            <div class="card-action">
              <a href="view.php?id=<?= $user['id'] ?>" class="btn pink darken-2 waves-effect waves-light">Voir</a>
              <a href="edit.php?id=<?= $user['id'] ?>" class="btn grey darken-1 waves-effect waves-light">Modifier</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <footer class="page-footer pink darken-2">
    <div class="container center white-text">
      © 2025 Alicia & Britney – CV numériques 🌸
    </div>
  </footer>
</body>
</html>