<?php
include_once 'inc/header.php';
include_once 'inc/database.php';

$era = $_GET['era'] ?? null;

$sql = "SELECT joukkueet.joukkueid, joukkueet.nimi AS joukkue_nimi, tulostaulu.era,
        tulostaulu.tehtava1aika, tulostaulu.tehtava2aika, tulostaulu.tehtava3aika, tulostaulu.kokonaisaika
        FROM tulostaulu
        INNER JOIN joukkueet ON tulostaulu.joukkueid = joukkueet.joukkueid
";

if ($era) {
  $sql .= " WHERE era = :era";
}
$sql .= " ORDER BY tulostaulu.kokonaisaika ASC";

$stmt = $pdo->prepare($sql);

if ($era) {
  $stmt->execute([':era' => $era]);
} else {
  $stmt->execute();
}

$tulokset = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

      <div class="mb-3 mt-2">
        <a href="?"><button class="btn btn-success">Kaikki erät</button></a>
        <a href="?era=alkuera"><button class="btn btn-success">Alkuerät</button></a>
        <a href="?era=kerailyera"><button class="btn btn-success">Keräilyerät</button></a>
        <a href="?era=valiera"><button class="btn btn-success">Välierät</button></a>
        <a href="?era=finaali"><button class="btn btn-success">Finaali</button></a>
      </div>

      <?php if (count($tulokset) > 0): ?>
        <table class="tausta">
          <thead>
            <tr>
              <th>Joukkue ID</th>
              <th>Joukkueen Nimi</th>
              <th>Vaihe</th>
              <th>Tehtävä 1 Aika</th>
              <th>Tehtävä 2 Aika</th>
              <th>Tehtävä 3 Aika</th>
              <th>Kokonaisaika</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($tulokset as $tulos): ?>
              <tr>
                <td><?= ($tulos['joukkueid']) ?></td>
                <td><?= ($tulos['joukkue_nimi']) ?></td>
                <td><?= ($tulos['era']) ?></td>
                <td><?= ($tulos['tehtava1aika']) ?></td>
                <td><?= ($tulos['tehtava2aika']) ?></td>
                <td><?= ($tulos['tehtava3aika']) ?></td>
                <td><?= ($tulos['kokonaisaika']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>Ei tallennettuja tuloksia</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include_once 'inc/footer.php'; ?>