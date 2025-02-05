<?php
include_once 'inc/header.php';
include_once 'inc/functions.php';
include_once 'inc/database.php';

if (!tarkistaKirjautuminen()) {
  header("Location: index.php");
  exit;
}

$sql = "SELECT joukkueid, nimi FROM joukkueet";
$stmt = $pdo->query($sql);
$joukkueet = $stmt->fetchAll(PDO::FETCH_ASSOC);

$joukkueetNimet = [];
foreach ($joukkueet as $joukkue) {
  $joukkueetNimet[$joukkue['joukkueid']] = $joukkue['nimi'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vaihe']) && isset($_POST['joukkueet'])) {
  $vaihe = $_POST['vaihe'];
  $valitutJoukkueet = $_POST['joukkueet'];

  if (count($valitutJoukkueet) < 6) {
    echo "<div class='alert alert-danger'>Valitse vähintään 6 joukkuetta</div>";
    exit;
  }

  // Sekoittaa joukkueet
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
}

// Arvottujen listojen tyhjennystä varten

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['poista'])) {
  $sql = "TRUNCATE TABLE arvotut_erat"; // Tyhjentää taulun kokonaan
  $pdo->exec($sql);
  echo "<div class='alert alert-danger'>Kaikki arvotut listat poistettu!</div>";
}

$sql = "SELECT vaihe, era_numero, joukkue_id FROM arvotut_erat ORDER BY vaihe, era_numero, joukkue_id";
$stmt = $pdo->query($sql);
$arvotutErat = $stmt->fetchAll(PDO::FETCH_ASSOC);

$alkuerat = [];
$valierat = [];

foreach ($arvotutErat as $rivi) {
  $joukkueNimi = $joukkueetNimet[$rivi['joukkue_id']] ?? "Tuntematon joukkue";

  if ($rivi['vaihe'] === "alkuera") {
    $alkuerat[$rivi['era_numero']][] = $joukkueNimi;
  } else if ($rivi['vaihe'] === "valiera") {
    $valierat[$rivi['era_numero']][] = $joukkueNimi;
  }
}
?>

<html>

<head>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>

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

        <!-- Poista listat nappi -->
        <form method="post" action="arvo_osallistujat.php" onsubmit="return confirm('Haluatko varmasti poistaa kaikki arvotut listat?');">
          <button type="submit" name="poista" class="btn btn-danger mt-3">Poista listat</button>
        </form>
      </div>
    </div>


    <!-- Arvottujen erien taulukot -->
    <div class="row mt-4 tausta">
      <!-- Alkuerät -->
      <div class="col-6">
        <h3>Alkuerät</h3>
        <table class="table">
          <thead>
            <tr>
              <th>Erä</th>
              <th>Joukkueet</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($alkuerat as $era_numero => $joukkueet): ?>
              <tr>
                <td>Erä <?= $era_numero ?></td>
                <td>
                  <ul>
                    <?php foreach ($joukkueet as $joukkue): ?>
                      <li><?= $joukkue ?></li>
                    <?php endforeach; ?>
                  </ul>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Välierät -->
      <div class="col-6">
        <h3>Välierät</h3>
        <table class="table">
          <thead>
            <tr>
              <th>Erä</th>
              <th>Joukkueet</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($valierat as $era_numero => $joukkueet): ?>
              <tr>
                <td>Erä <?= $era_numero ?></td>
                <td>
                  <ul>
                    <?php foreach ($joukkueet as $joukkue): ?>
                      <li><?= $joukkue ?></li>
                    <?php endforeach; ?>
                  </ul>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>

</html>

<?php
include_once 'inc/footer.php';
?>