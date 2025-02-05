<?php
include_once 'inc/header.php';
include_once 'inc/functions.php';
include_once 'inc/database.php';

if (!tarkistaKirjautuminen()) {
  header("Location: index.php");
  exit;
}

// try {
//   $stmt = $pdo->query("SELECT joukkueid, nimi FROM joukkueet");
//   $joukkueet = $stmt->fetchAll(PDO::FETCH_ASSOC);
// } catch (PDOException $e) {
//   die("Virhe: " . $e->getMessage());
// }

$sql = "SELECT joukkueid, nimi FROM joukkueet";
$stmt = $pdo->query($sql);
$joukkueet = $stmt->fetchAll(PDO::FETCH_ASSOC);

$joukkueetNimet = [];
foreach ($joukkueet as $joukkue) {
  $joukkueetNimet[$joukkue['joukkueid']] = $joukkue['nimi'];
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

  $sql = "INSERT INTO arvotut_erat (vaihe, era_numero, joukkue_id) VALUES (:vaihe, :era_numero, :joukkue_id)";
  $stmt = $pdo->prepare($sql);


  foreach ($erät as $i => $erä) {
    $era_numero = $i + 1;

    foreach ($erä as $joukkueID) {
      $stmt->execute([
        ':vaihe' => $vaihe,
        ':era_numero' => $era_numero,
        ':joukkue_id' => $joukkueID
      ]);
    }
  }

  echo "<div class='alert alert-success'>Arvotut listat tallennettu!</div>";
  foreach ($erät as $i => $erä) {

    foreach ($erä as $joukkueID) {
      $joukkueNimi = $joukkueetNimet[$joukkueID] ?? "Tuntematon joukkue";
    }
  }
}
?>

<html>

<head>
  <link rel="stylesheet" href="css/styles.css">
</head>

</html>

<div class="container">
  <div class="row">
    <div class="col-4 mx-auto tausta">

      <form method="post" action="arvo_osallistujat.php">
        <label for="vaihe">Valitse erä:</label>
        <select name="vaihe" id="vaihe" required>
          <option value="alkuera">Alkuerä</option>
          <option value="valiera">Välierä</option>
        </select>

        <div class="joukkueet-lista-container">
          <label for="joukkueet">Valitse joukkueet:</label>
          <div class="joukkueet-lista">
            <?php foreach ($joukkueet as $joukkue): ?>
              <label>
                <input type="checkbox" name="joukkueet[]" value="<?= $joukkue['joukkueid'] ?>">
                <?= $joukkue['nimi'] ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="mb-2">
          <button type="button" id="select-all" class="btn btn-success btn-sm">Valitse kaikki</button>
          <button type="button" id="clear-all" class="btn btn-danger btn-sm">Tyhjennä</button>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Arvo listat</button>
      </form>

    </div>
  </div>
</div>

<?php
include_once 'inc/footer.php';
?>