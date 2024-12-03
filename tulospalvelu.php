<?php
require_once 'inc/header.php';
require_once 'inc/database.php';

$vaihe = $_GET['vaihe'] ?? null;

$sql = "SELECT joukkueet.id AS joukkue_id, joukkueet.nimi AS joukkue_nimi, erat.vaihe,
        erat.tehtava1_aika, erat.tehtava2_aika, erat.tehtava3_aika, erat.kokonaisaika
        FROM erat
        INNER JOIN joukkueet ON erat.joukkue_id = joukkueet.id
";

if ($vaihe) {
  $sql .= " WHERE vaihe = :vaihe";
}
$sql .= " ORDER BY erat.kokonaisaika ASC";

$stmt = $pdo->prepare($sql);

if ($vaihe) {
  $stmt->execute([':vaihe' => $vaihe]);
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

  <div class="mb-3">
    <a href="?"><button class="btn btn-success">Kaikki erät</button></a>
    <a href="?vaihe=alkuera"><button class="btn btn-success">Alkuerät</button></a>
    <a href="?vaihe=kerailyera"><button class="btn btn-success">Keräilyerät</button></a>
    <a href="?vaihe=valiera"><button class="btn btn-success">Välierät</button></a>
    <a href="?vaihe=finaali"><button class="btn btn-success">Finaali</button></a>
  </div>

  <?php if (count($tulokset) > 0): ?>
    <table>
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
            <td><?= ($tulos['joukkue_id']) ?></td>
            <td><?= ($tulos['joukkue_nimi']) ?></td>
            <td><?= ($tulos['vaihe']) ?></td>
            <td><?= ($tulos['tehtava1_aika']) ?></td>
            <td><?= ($tulos['tehtava2_aika']) ?></td>
            <td><?= ($tulos['tehtava3_aika']) ?></td>
            <td><?= ($tulos['kokonaisaika']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Ei tallennettuja tuloksia</p>
  <?php endif; ?>
</div>

<?php include_once 'inc/footer.php'; ?>