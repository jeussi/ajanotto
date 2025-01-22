<?php
include_once 'inc/header.php';
include_once 'inc/functions.php';
include_once 'inc/database.php';

if (!tarkistaKirjautuminen()){
  header("Location: index.php");
  exit;
}

try {
  $stmt = $pdo->query("SELECT id, nimi FROM joukkueet");
  $joukkueet = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Virhe: " . $e->getMessage());
}

$joukkueetNimet = [];
foreach ($joukkueet as $joukkue) {
  $joukkueetNimet[$joukkue['id']] = $joukkue['nimi'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $vaihe = $_POST['vaihe'];
  $valitutJoukkueet = $_POST['joukkueet'];

  if (count($valitutJoukkueet) < 6) {
    echo "Valitse vähintään 6 joukkuetta.";
    exit;
  }

  // Sekoitetaan joukkueet
  shuffle($valitutJoukkueet);

  $erät = array_chunk($valitutJoukkueet, 6);

  echo "<h2>Arvotut listat ($vaihe)</h2>";
  foreach ($erät as $i => $erä) {
    echo "<h3>Erä " . ($i + 1) . "</h3>";
    echo "<ul>";
    foreach ($erä as $joukkue) {
      $joukkueNimi = $joukkueetNimet[$joukkue];
      echo "<li>$joukkueNimi</li>";
    }
    echo "</ul>";
  }
}
?>

<html>
  <head>
    <link rel="stylesheet" href="css/styles.css">
  </head>
</html>

<div class="container">
  <form method="post" action="arvo_osallistujat.php">
    <label for="vaihe">Valitse vaihe:</label>
    <select name="vaihe" id="vaihe" required>
      <option value="alkuera">Alkuerä</option>
      <option value="valiera">Välierä</option>
    </select>

    <h3>Valitse joukkueet:</h3>
    <div class="mb-2">
      <button type="button" id="select-all" class="btn btn-success btn-sm">Valitse kaikki</button>
      <button type="button" id="clear-all" class="btn btn-danger btn-sm">Tyhjennä</button>
    </div>

    <div class="joukkueet-lista">
      <?php foreach ($joukkueet as $joukkue): ?>
        <label class="joukkue-item">
          <input type="checkbox" name="joukkueet[]" value="<?= $joukkue['id'] ?>">
          <?= htmlspecialchars($joukkue['nimi']) ?>
        </label>
      <?php endforeach; ?>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Arvo listat</button>
  </form>
</div>


<?php 
include_once 'inc/footer.php'; 
?>
