<?php
require_once 'inc/header.php';
require_once 'inc/database.php';
require_once 'inc/functions.php';

if (!tarkistaRooli('tuomari') && !tarkistaRooli('admin')) {
  header("Location: index.php");
  exit;
}

$sql = "SELECT id, nimi FROM joukkueet";
$stmt = $pdo->query($sql);
$joukkueet = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $joukkue_id = $_POST['joukkue_id'];
  $vaihe = $_POST['vaihe'];
  $tehtava1_aika = $_POST['tehtava1_aika'];
  $tehtava2_aika = $_POST['tehtava2_aika'];
  $tehtava3_aika = $_POST['tehtava3_aika'];
  $kokonaisaika = $_POST['kokonaisaika'];

  $sql = "INSERT INTO erat (vaihe, joukkue_id, tehtava1_aika, tehtava2_aika, tehtava3_aika, kokonaisaika)
            VALUES (:vaihe, :joukkue_id, :tehtava1_aika, :tehtava2_aika, :tehtava3_aika, :kokonaisaika)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':vaihe' => $vaihe,
    ':joukkue_id' => $joukkue_id,
    ':tehtava1_aika' => $tehtava1_aika,
    ':tehtava2_aika' => $tehtava2_aika,
    ':tehtava3_aika' => $tehtava3_aika,
    ':kokonaisaika' => $kokonaisaika,
  ]);

  echo "<div class='alert alert-success'>Aika tallennettu onnistuneesti!</div>";

}
?>

<div class="container">
  <h1>Ajanotto</h1>
  <form id="timeForm" method="post">
    <div class="mb-3">
      <label for="joukkue" class="form-label">Valitse joukkue</label>
      <select id="joukkue" name="joukkue_id" class="form-select" required>
        <option value="">- Valitse joukkue -</option>
        <?php foreach ($joukkueet as $joukkue): ?>
          <option value="<?= $joukkue['id'] ?>"><?= $joukkue['nimi'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="vaihe" class="form-label">Vaihe</label>
      <select id="vaihe" name="vaihe" class="form-select" required>
        <option value="alkuera">Alkuerä</option>
        <option value="kerailyera">Keräilyerä</option>
        <option value="valiera">Välierä</option>
        <option value="finaali">Finaali</option>
      </select>
    </div>

    <div id="timer">
      <h2 id="display">00:00:00</h2>
      <button type="button" id="startBtn" class="btn btn-success">Käynnistä</button>
      <button type="button" id="stopBtn" class="btn btn-danger">Pysäytä</button>
      <button type="button" id="resetBtn" class="btn btn-secondary">Nollaa</button>
      <button type="button" id="lapBtn" class="btn btn-primary">Kierros</button>
    </div>

    <div id="laps"></div>

    <h3 class="mt-4">Syötä tehtävien ajat</h3>
    <div class="mb-3">
      <label for="tehtava1_aika" class="form-label">Tehtävä 1 aika</label>
      <input type="text" id="tehtava1_aika" name="tehtava1_aika" class="form-control" placeholder="Syötä tehtävä 1 aika (mm:ss:ms)">
    </div>
    <div class="mb-3">
      <label for="tehtava2_aika" class="form-label">Tehtävä 2 aika</label>
      <input type="text" id="tehtava2_aika" name="tehtava2_aika" class="form-control" placeholder="Syötä tehtävä 2 aika (mm:ss:ms)">
    </div>
    <div class="mb-3">
      <label for="tehtava3_aika" class="form-label">Tehtävä 3 aika</label>
      <input type="text" id="tehtava3_aika" name="tehtava3_aika" class="form-control" placeholder="Syötä tehtävä 3 aika (mm:ss:ms)">
    </div>
    <div class="mb-3">
      <label for="kokonaisaika" class="form-label">Kokonaisaika</label>
      <input type="text" id="kokonaisaika" name="kokonaisaika" class="form-control" placeholder="Syötä kokonaisaika (mm:ss:ms)">
    </div>

    <button type="submit" class="btn btn-primary mt-3">Tallenna</button>
  </form>
</div>

<?php include_once 'inc/footer.php'; ?>