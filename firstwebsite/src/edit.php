<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'db_connect.php';
session_start();

$user_id = $_GET['id'] ?? null;
if (!$user_id) die("Aucun ID reçu");

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) die("Utilisateur introuvable");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  switch ($action) {
    case 'add_skill':
      $pdo->prepare("INSERT INTO skills (user_id, name, level) VALUES (?, ?, ?)")
          ->execute([$user_id, $_POST['name'], $_POST['level']]);
      $_SESSION['message'] = "✅ Compétence ajoutée avec succès !";
      break;

    case 'update_skill':
      $pdo->prepare("UPDATE skills SET name=?, level=? WHERE id=?")
          ->execute([$_POST['name'], $_POST['level'], $_POST['id']]);
      $_SESSION['message'] = "✏️ Compétence mise à jour !";
      break;

    case 'delete_skill':
      $pdo->prepare("DELETE FROM skills WHERE id=?")->execute([$_POST['id']]);
      $_SESSION['message'] = "🗑 Compétence supprimée.";
      break;

    case 'add_exp':
      $pdo->prepare("INSERT INTO experiences (user_id, name, description, startdate, enddate) VALUES (?, ?, ?, ?, ?)")
          ->execute([$user_id, $_POST['name'], $_POST['description'], $_POST['startdate'], $_POST['enddate']]);
      $_SESSION['message'] = "✅ Expérience ajoutée !";
      break;

    case 'delete_exp':
      $pdo->prepare("DELETE FROM experiences WHERE id=?")->execute([$_POST['id']]);
      $_SESSION['message'] = "🗑 Expérience supprimée.";
      break;

    case 'add_edu':
      $pdo->prepare("INSERT INTO educations (user_id, name, description, startdate, enddate) VALUES (?, ?, ?, ?, ?)")
          ->execute([$user_id, $_POST['name'], $_POST['description'], $_POST['startdate'], $_POST['enddate']]);
      $_SESSION['message'] = "✅ Formation ajoutée !";
      break;

    case 'delete_edu':
      $pdo->prepare("DELETE FROM educations WHERE id=?")->execute([$_POST['id']]);
      $_SESSION['message'] = "🗑 Formation supprimée.";
      break;
  }
  header("Location: edit.php?id=$user_id");
  exit;
}

// Récupération des données
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
  <title>Modifier le CV de <?= htmlspecialchars($user['firstname']) ?></title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
  <script src="assets/js/script.js?v=<?php echo time(); ?>"></script>
</head>

<body class="pink lighten-5">
  <nav class="pink darken-2 center-align">
    <div class="nav-wrapper">
      <a href="index.php" class="brand-title white-text">Édition du CV</a>
    </div>
  </nav>

  <nav class="pink lighten-4">
    <div class="nav-wrapper center-align">
      <ul style="display:flex; justify-content:center; gap:20px; padding:10px 0; margin:0; list-style:none;">
        <li><a href="index.php" class="pink-text text-darken-2">Accueil</a></li>
      </ul>
    </div>
  </nav>

  <main class="container section">
    <h4 class="pink-text text-darken-2 center">
      Modifier le CV de <?= htmlspecialchars($user['firstname']) ?>
    </h4>

    <!-- ✅ Message de confirmation -->
    <?php if (!empty($_SESSION['message'])): ?>
      <p class="center" style="color:#d81b60; font-weight:500; margin-top:10px;">
        <?= htmlspecialchars($_SESSION['message']) ?>
      </p>
      <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <section>
      <h5 class="pink-text text-darken-2">Compétences</h5>
      <?php if (count($skills) > 0): ?>
      <ul class="collection">
        <?php foreach ($skills as $skill): ?>
          <li class="collection-item">
            <form method="post" class="row">
              <input type="hidden" name="id" value="<?= $skill['id'] ?>">
              <div class="input-field col s4">
                <input type="text" name="name" value="<?= htmlspecialchars($skill['name']) ?>">
              </div>
              <div class="input-field col s4">
                <input type="text" name="level" value="<?= htmlspecialchars($skill['level']) ?>">
              </div>
              <div class="col s4">
                <button class="btn-small pink" name="action" value="update_skill">✏️</button>
                <button class="btn-small grey" name="action" value="delete_skill">🗑</button>
              </div>
            </form>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php else: ?>
        <p class="grey-text">Aucune compétence enregistrée.</p>
      <?php endif; ?>

      <form method="post" class="card-panel">
        <h6>Ajouter une compétence</h6>
        <input type="text" name="name" placeholder="Nom" required>
        <input type="text" name="level" placeholder="Niveau" required>
        <button class="btn pink" name="action" value="add_skill">Ajouter</button>
      </form>
    </section>

    <section>
      <h5 class="pink-text text-darken-2">Expériences</h5>
      <?php if (count($experiences) > 0): ?>
        <?php foreach ($experiences as $exp): ?>
          <div class="card-panel">
            <strong><?= htmlspecialchars($exp['name']) ?></strong><br>
            <?= htmlspecialchars($exp['description']) ?><br>
            <small><?= htmlspecialchars($exp['startdate']) ?> → <?= htmlspecialchars($exp['enddate']) ?></small>
            <form method="post" style="margin-top:10px;">
              <input type="hidden" name="id" value="<?= $exp['id'] ?>">
              <button class="btn-small grey" name="action" value="delete_exp">🗑 Supprimer</button>
            </form>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="grey-text">Aucune expérience enregistrée.</p>
      <?php endif; ?>

      <form method="post" class="card-panel">
        <h6>Ajouter une expérience</h6>
        <input type="text" name="name" placeholder="Titre" required>
        <textarea name="description" placeholder="Description" class="materialize-textarea" required></textarea>
        <input type="date" name="startdate" required>
        <input type="date" name="enddate" required>
        <button class="btn pink" name="action" value="add_exp">Ajouter</button>
      </form>
    </section>

    <section>
      <h5 class="pink-text text-darken-2">Formations</h5>
      <?php if (count($educations) > 0): ?>
        <?php foreach ($educations as $edu): ?>
          <div class="card-panel">
            <strong><?= htmlspecialchars($edu['name']) ?></strong><br>
            <?= htmlspecialchars($edu['description']) ?><br>
            <small><?= htmlspecialchars($edu['startdate']) ?> → <?= htmlspecialchars($edu['enddate']) ?></small>
            <form method="post" style="margin-top:10px;">
              <input type="hidden" name="id" value="<?= $edu['id'] ?>">
              <button class="btn-small grey" name="action" value="delete_edu">🗑 Supprimer</button>
            </form>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="grey-text">Aucune formation enregistrée.</p>
      <?php endif; ?>

      <form method="post" class="card-panel">
        <h6>Ajouter une formation</h6>
        <input type="text" name="name" placeholder="Nom de la formation" required>
        <textarea name="description" placeholder="Description" class="materialize-textarea" required></textarea>
        <input type="date" name="startdate" required>
        <input type="date" name="enddate" required>
        <button class="btn pink" name="action" value="add_edu">Ajouter</button>
      </form>
    </section>

  </main>

  <footer class="page-footer pink darken-2">
    <div class="container center white-text">
      © 2025 Alicia & Britney – CV numériques 🌸
    </div>
  </footer>
</body>
</html>
