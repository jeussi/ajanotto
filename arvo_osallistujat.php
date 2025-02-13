<?php
include_once 'inc/header.php';
include_once 'inc/functions.php';
include_once 'inc/database.php';

if (!tarkistaKirjautuminen()) {
  header("Location: index.php");
  exit;
}

// Haetaan kaikki joukkueet
$sql = "SELECT joukkueid, nimi FROM joukkueet";
$stmt = $pdo->query($sql);
$joukkueet = $stmt->fetchAll(PDO::FETCH_ASSOC);

$joukkueetNimet = [];
foreach ($joukkueet as $joukkue) {
  $joukkueetNimet[$joukkue['joukkueid']] = $joukkue['nimi'];
}

// Haetaan kaikki tuomarit
$sql = "SELECT id, kayttajanimi FROM kayttajat WHERE rooli = 'tuomari'";
$stmt = $pdo->query($sql);
$tuomarit = $stmt->fetchAll(PDO::FETCH_ASSOC);
$tuomariIDt = array_column($tuomarit, 'id');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vaihe']) && isset($_POST['joukkueet'])) {
  $vaihe = $_POST['vaihe'];
  $valitutJoukkueet = $_POST['joukkueet'];

  if (count($valitutJoukkueet) < 6) {
    echo "<div class='alert alert-danger'>Valitse vähintään 6 joukkuetta</div>";
    exit;
  }

  // Sekoitetaan joukkueet
  shuffle($valitutJoukkueet);
  $erät = array_chunk($valitutJoukkueet, 6);

  $pdo->beginTransaction();

  try {
    $pdo->exec("DELETE FROM arvotut_erat WHERE vaihe = '$vaihe'");

    $sql = "INSERT INTO arvotut_erat (vaihe, era_numero, joukkue_id, tuomari_id) 
            VALUES (:vaihe, :era_numero, :joukkue_id, :tuomari_id)";
    $stmt = $pdo->prepare($sql);

    foreach ($erät as $i => $erä) {
      $era_numero = $i + 1;
      $kaytetytTuomarit = [];

      foreach ($erä as $joukkueID) {
        do {
          $arvottuTuomari = $tuomariIDt[array_rand($tuomariIDt)];
        } while (in_array($arvottuTuomari, $kaytetytTuomarit));
        
        $kaytetytTuomarit[] = $arvottuTuomari;

        $stmt->execute([ 
          ':vaihe' => $vaihe,
          ':era_numero' => $era_numero,
          ':joukkue_id' => $joukkueID,
          ':tuomari_id' => $arvottuTuomari
        ]);
      }
    }

    $pdo->commit();
    echo "<div class='alert alert-success'>Arvotut listat ja tuomarit tallennettu!</div>";

  } catch (Exception $e) {
    $pdo->rollBack();
    echo "<div class='alert alert-danger'>Virhe: " . $e->getMessage() . "</div>";
  }
}

// Arvottujen listojen tyhjennys
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['poista'])) {
  $pdo->exec("TRUNCATE TABLE arvotut_erat");
  echo "<div class='alert alert-danger'>Kaikki arvotut listat ja tuomarit poistettu!</div>";
}

$sql = "SELECT * FROM arvotut_erat ORDER BY vaihe, era_numero ASC";
$stmt = $pdo->query($sql);
$arvotutErat = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<html>
  <link rel="stylesheet" href="css/styles.css">
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
        <button type="submit" class="btn btn-primary mt-3">Arvo listat ja tuomarit</button>
      </form>

      <form method="post" action="arvo_osallistujat.php" onsubmit="return confirm('Haluatko varmasti poistaa kaikki arvotut listat ja tuomarit?');">
        <button type="submit" name="poista" class="btn btn-danger mt-3">Poista listat ja tuomarit</button>
      </form>

      <hr>

      <h3>Alkuerät</h3>
      <?php 
      //ALKUERÄT
      $alkuerat = array_filter($arvotutErat, function($era) {
          return $era['vaihe'] === 'alkuera';
      });
      if (count($alkuerat) > 0): ?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Erä</th>
              <th>Joukkue</th>
              <th>Tuomari</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($alkuerat as $erä): ?>
              <tr>
                <td><?= $erä['era_numero'] ?></td>
                <td><?= $joukkueetNimet[$erä['joukkue_id']] ?? 'Tuntematon joukkue' ?></td>
                <td><?= $tuomarit[array_search($erä['tuomari_id'], array_column($tuomarit, 'id'))]['kayttajanimi'] ?? 'Tuntematon tuomari' ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>Ei arvottuja alkueriä.</p>
      <?php endif; ?>

      <hr>

      <h3>Välierät</h3>
      <?php 
      //VÄLIERÄT
      $valierat = array_filter($arvotutErat, function($era) {
          return $era['vaihe'] === 'valiera';
      });
      if (count($valierat) > 0): ?>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Erä</th>
              <th>Joukkue</th>
              <th>Tuomari</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($valierat as $erä): ?>
              <tr>
                <td><?= $erä['era_numero'] ?></td>
                <td><?= $joukkueetNimet[$erä['joukkue_id']] ?? 'Tuntematon joukkue' ?></td>
                <td><?= $tuomarit[array_search($erä['tuomari_id'], array_column($tuomarit, 'id'))]['kayttajanimi'] ?? 'Tuntematon tuomari' ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>Ei arvottuja välieriä.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include_once 'inc/footer.php'; ?>
