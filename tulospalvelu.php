<?php
include_once 'inc/header.php';
include_once 'inc/database.php';

$era = $_GET['era'] ?? null;
$era_numero = $_GET['era_numero'] ?? null;

$sql = "SELECT joukkueet.joukkueid, joukkueet.nimi AS joukkue_nimi, tulostaulu.era, tulostaulu.era_numero,
        tulostaulu.tehtava1aika, tulostaulu.tehtava2aika, tulostaulu.tehtava3aika, tulostaulu.kokonaisaika
        FROM tulostaulu
        INNER JOIN joukkueet ON tulostaulu.joukkueid = joukkueet.joukkueid
        WHERE tulostaulu.era = :era AND tulostaulu.era_numero = :era_numero
        ORDER BY tulostaulu.kokonaisaika ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute([':era' => $era, ':era_numero' => $era_numero]);

$tulokset = $stmt->fetchAll(PDO::FETCH_ASSOC);
$nopeinaika = $tulokset[0]['kokonaisaika'] ?? null;

?>

<html>

<head>
  <link rel="stylesheet" href="css/styles.css">
</head>

</html>

<div class="container">
  <div class="row">
    <div class="col-10 mx-auto tausta">
      <div class="row">
        <h2>Tulospalvelu</h2>
      </div>
      <form id="roundForm" method="get">
        <div class="mb-3">
          <label for="era" class="form-label">Erä</label>
          <select id="era" name="era" class="form-select" required>
              <option value="">- Valitse erätyyppi -</option>
              <option value="Alkuera">Alkuerä</option>
              <option value="Kerailyera">Keräilyerä</option>
              <option value="Valiera">Välierä</option>
              <option value="Finaali">Finaali</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="era_numero" class="form-label">Erä Numero</label>
          <select id="era_numero" name="era_numero" class="form-select" required>
              <option value="">- Valitse eränumero -</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Näytä tulokset</button>
      </form>

      <?php if (count($tulokset) > 0): ?>
        <table class="tausta">
          <thead>
            <tr>
              <th>Joukkue ID</th>
              <th>Joukkueen Nimi</th>
              <th>Erä</th>
              <th>Erä numero</th>
              <th>Tehtävä 1 Aika</th>
              <th>Tehtävä 2 Aika</th>
              <th>Tehtävä 3 Aika</th>
              <th>Kokonaisaika</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($tulokset as $tulos): ?>
              <tr class="<?= ($tulos['kokonaisaika'] == $nopeinaika) ? 'nopein' : '' ?>">
                <td><?= ($tulos['joukkueid']) ?></td>
                <td><?= ($tulos['joukkue_nimi']) ?></td>
                <td><?= ($tulos['era']) ?></td>
                <td><?= ($tulos['era_numero']) ?></td>
                <td><?= ($tulos['tehtava1aika']) ?></td>
                <td><?= ($tulos['tehtava2aika']) ?></td>
                <td><?= ($tulos['tehtava3aika']) ?></td>
                <td><?= ($tulos['kokonaisaika']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>Valitse era ja era numero</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/tulospalvelu_erat.js"></script>
<?php include_once 'inc/footer.php'; ?>