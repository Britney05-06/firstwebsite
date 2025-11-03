<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'db_connect.php';

$user_id = $_GET['id'] ?? null;
if (!$user_id) die("Aucun ID reçu");

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) die("Utilisateur introuvable");

$stmt_exp = $pdo->prepare("SELECT * FROM experiences WHERE user_id = ?");
$stmt_exp->execute([$user_id]);
$experiences = $stmt_exp->fetchAll(PDO::FETCH_ASSOC);

$stmt_edu = $pdo->prepare("SELECT * FROM educations WHERE user_id = ?");
$stmt_edu->execute([$user_id]);
$educations = $stmt_edu->fetchAll(PDO::FETCH_ASSOC);

$stmt_skills = $pdo->prepare("SELECT * FROM skills WHERE user_id = ?");
$stmt_skills->execute([$user_id]);
$skills = $stmt_skills->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>

<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($user['firstname']) ?> <?= htmlspecialchars($user['lastname']) ?> - CV</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
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
        display: flex;
        flex-direction: column;
    }
  </style>
</head>

<body class="pink lighten-5">
  <nav class="pink darken-2 center-align">
    <div class="nav-wrapper">
      <a href="index.php" class="brand-title white-text">CV de <?= htmlspecialchars($user['firstname']) ?></a>
    </div>
  </nav>
  
  <nav class="pink lighten-4">
    <div class="nav-wrapper center-align">
      <ul class="hide-on-med-and-down" style="display:flex; justify-content:center; gap:20px;">
        <li><a href="#exp" class="pink-text text-darken-2">Expériences</a></li>
        <li><a href="#edu" class="pink-text text-darken-2">Formations</a></li>
        <li><a href="#skills" class="pink-text text-darken-2">Compétences</a></li>
        <li><a href="#contact" class="pink-text text-darken-2">Contact</a></li>
        <li><a href="index.php" class="pink-text text-darken-2">Accueil</a></li>
      </ul>
    </div>
  </nav>

  <main class="container section">
    <div class="card hoverable center">
      <div class="card-content">
        <h5 id="exp" class="pink-text text-darken-2">Profil</h5>
        <img src="../assets/img/<?= htmlspecialchars($user['picture']) ?>" alt="<?= htmlspecialchars($user['firstname']) ?>" class="circle responsive-img" style="width:130px;height:130px;object-fit:cover;">
        <h4 class="pink-text text-darken-2"><?= htmlspecialchars($user['firstname']) ?> <?= htmlspecialchars($user['lastname']) ?></h4>
        <p class="pink-text text-darken-2">Numéro de téléphone: <?= htmlspecialchars($user['phone']) ?></p>
        <p class="pink-text text-darken-2">Email: <a href="mailto:<?= htmlspecialchars($user['email']) ?>" class="pink-text text-darken-2">
          <?= htmlspecialchars($user['email']) ?>
        </a></p>
      </div>
    </div>

    <h5 id="exp" class="pink-text text-darken-2">Expériences</h5>
    <?php if (count($experiences) > 0): ?>
    <ul class="collection">
      <?php foreach ($experiences as $exp): ?>
        <li class="collection-item">
          <strong><?= htmlspecialchars($exp['name']) ?></strong><br>
          <span><?= htmlspecialchars($exp['description']) ?></span><br>
          <small><?= htmlspecialchars($exp['startdate']) ?> → <?= htmlspecialchars($exp['enddate']) ?></small>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php else: ?>
      <p class="grey-text">Aucune expérience enregistrée.</p>
    <?php endif; ?>

    <h5 id="edu" class="pink-text text-darken-2">Formations</h5>
    <?php if (count($educations) > 0): ?>
    <ul class="collection">
      <?php foreach ($educations as $edu): ?>
        <li class="collection-item">
          <strong><?= htmlspecialchars($edu['name']) ?></strong><br>
          <span><?= htmlspecialchars($edu['description']) ?></span><br>
          <small><?= htmlspecialchars($edu['startdate']) ?> → <?= htmlspecialchars($edu['enddate']) ?></small>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php else: ?>
      <p class="grey-text">Aucune formation enregistrée.</p>
    <?php endif; ?>

    <h5 id="skills" class="pink-text text-darken-2">Compétences</h5>
    <?php if (count($skills) > 0): ?>
    <div class="row">
      <?php foreach ($skills as $skill): ?>
        <div class="chip pink lighten-4 pink-text text-darken-2">
          <?= htmlspecialchars($skill['name']) ?> - <?= htmlspecialchars($skill['level']) ?>
        </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
      <p class="grey-text">Aucune compétence enregistrée.</p>
    <?php endif; ?>

  </main>

  <footer class="page-footer pink darken-2">
    <div class="container center white-text">
      © 2025 Alicia & Britney – CV numériques 🌸
    </div>
  </footer>
</body>
</html>