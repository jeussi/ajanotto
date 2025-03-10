<?php
include_once 'inc/header.php';
include_once 'inc/database.php';
include_once 'inc/functions.php';

if (!tarkistaRooli('tuomari') && !tarkistaRooli('admin')) {
    header("Location: index.php");
    exit;
}

$tuomari_id = $_SESSION['id']; 

$sql = "SELECT j.joukkueid, j.nimi, ae.vaihe, ae.era_numero
        FROM arvotut_erat ae
        JOIN joukkueet j ON ae.joukkue_id = j.joukkueid
        WHERE ae.tuomari_id = :tuomari_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':tuomari_id' => $tuomari_id]);
$arvotut_joukkueet = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $joukkueid = $_POST['joukkueid'];
    $era = $_POST['era'];
    $era_numero = $_POST['era_numero'];
    $tehtava1aika = $_POST['tehtava1aika'];
    $tehtava2aika = $_POST['tehtava2aika'];
    $tehtava3aika = $_POST['tehtava3aika'];
    $kokonaisaika = $_POST['kokonaisaika'];

    $sql = "INSERT INTO tulostaulu (era, era_numero, joukkueid, tehtava1aika, tehtava2aika, tehtava3aika, kokonaisaika)
            VALUES (:era, :era_numero, :joukkueid, :tehtava1aika, :tehtava2aika, :tehtava3aika, :kokonaisaika)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':era' => $era,
        ':era_numero' => $era_numero,
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
            <select id="joukkue" name="joukkueid" class="form-select" onchange="updateEraNumero()" required>
                <option value="">- Valitse joukkue -</option>
                <?php foreach ($arvotut_joukkueet as $joukkue): ?>
                    <option value="<?= $joukkue['joukkueid'] ?>" data-era="<?= $joukkue['vaihe'] ?>" data-era-numero="<?= $joukkue['era_numero'] ?>">
                        <?= $joukkue['nimi'] ?> - <?= $joukkue['vaihe'] ?> (Erä <?= $joukkue['era_numero'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="timer">
            <h2 id="display">00:00:00</h2>
            <button type="button" id="startBtn" class="btn btn-success">Käynnistä</button>
            <button type="button" id="stopBtn" class="btn btn-danger">Pysäytä</button>
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
        <input type="hidden" id="era_numero" name="era_numero">
        <input type="hidden" id="era" name="era">
        <button type="submit" class="btn btn-primary mt-3">Tallenna</button>
    </form>
    <script>
        function updateEraNumero() {
            const selectedOption = document.querySelector('#joukkue option:checked');
            const era = selectedOption ? selectedOption.getAttribute('data-era') : '';
            const eraNumero = selectedOption ? selectedOption.getAttribute('data-era-numero') : '';
            document.getElementById('era').value = era;
            document.getElementById('era_numero').value = eraNumero;
        }
    </script>
    <script src="js/ajastin.js"></script>
</div>

<?php include_once 'inc/footer.php'; ?>
