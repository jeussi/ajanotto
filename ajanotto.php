<?php
include_once 'inc/header.php';
include_once 'inc/database.php';
include_once 'inc/functions.php';

if (!tarkistaRooli('tuomari') && !tarkistaRooli('admin')) {
  header("Location: index.php");
  exit;
}

$sql = "SELECT joukkueid, nimi FROM joukkueet";
$stmt = $pdo->query($sql);
$joukkueet = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $joukkueid = $_POST['joukkueid'];
  $era = $_POST['era'];
  $tehtava1aika = $_POST['tehtava1aika'];
  $tehtava2aika = $_POST['tehtava2aika'];
  $tehtava3aika = $_POST['tehtava3aika'];
  $kokonaisaika = $_POST['kokonaisaika'];

  $sql = "INSERT INTO tulostaulu (era, joukkueid, tehtava1aika, tehtava2aika, tehtava3aika, kokonaisaika)
            VALUES (:era, :joukkueid, :tehtava1aika, :tehtava2aika, :tehtava3aika, :kokonaisaika)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':era' => $era,
    ':joukkueid' => $joukkueid,
    ':tehtava1aika' => $tehtava1aika,
    ':tehtava2aika' => $tehtava2aika,
    ':tehtava3aika' => $tehtava3aika,
    ':kokonaisaika' => $kokonaisaika,
  ]);

  echo "<div class='alert alert-success'>Aika tallennettu onnistuneesti!</div>";

}
?>

<div class="container tausta">
  <h1>Ajanotto</h1>
  <form id="timeForm" method="post">
    <div class="mb-3">
      <label for="joukkue" class="form-label">Valitse joukkue</label>
      <select id="joukkue" name="joukkueid" class="form-select" required>
        <option value="">- Valitse joukkue -</option>
        <?php foreach ($joukkueet as $joukkue): ?>
          <option value="<?= $joukkue['joukkueid'] ?>"><?= $joukkue['nimi'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="era" class="form-label">Erä</label>
      <select id="era" name="era" class="form-select" required>
        <option value="Alkuera">Alkuerä</option>
        <option value="Kerailyera">Keräilyerä</option>
        <option value="Valiera">Välierä</option>
        <option value="Finaali">Finaali</option>
      </select>
    </div>

    <div id="timer">
      <h2 id="display">00:00:00</h2>
      <button type="button" id="startBtn" class="btn btn-success">Käynnistä</button>
      <button type="button" id="stopBtn" class="btn btn-danger">Pysäytä</button>
      <!--<button type="button" id="resetBtn" class="btn btn-secondary">Nollaa</button> -->
      <button type="button" id="lapBtn" class="btn btn-primary">Kierros</button>
    </div>

    <div id="laps">
      <div class="mb-3">
        <label for="tehtava1aika" class="form-label">Tehtävä 1 aika</label>
        <input type="text" id="tehtava1aika" name="tehtava1aika" class="form-control" placeholder="Tehtävä 1 aika (mm:ss:ms)" readonly>

        <label for="tehtava2aika" class="form-label">Tehtävä 2 aika</label>
        <input type="text" id="tehtava2aika" name="tehtava2aika" class="form-control" placeholder="Tehtävä 2 aika (mm:ss:ms)" readonly>

        <label for="tehtava3aika" class="form-label">Tehtävä 3 aika</label>
        <input type="text" id="tehtava3aika" name="tehtava3aika" class="form-control" placeholder="Tehtävä 3 aika (mm:ss:ms)" readonly>

        <label for="kokonaisaika" class="form-label">Kokonaisaika</label>
        <input type="text" id="kokonaisaika" name="kokonaisaika" class="form-control" placeholder="Kokonaisaika (mm:ss:ms)" readonly>
      </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Tallenna</button>
  </form>

<!--    <h3 class="mt-4">Syötä tehtävien ajat</h3>
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
-->
<script src="js/ajastin.js"></script>
<?php include_once 'inc/footer.php'; ?>