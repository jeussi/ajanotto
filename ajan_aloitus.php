<?php
include_once 'inc/header.php';
include_once 'inc/database.php';

$query = "SELECT DISTINCT era_numero, vaihe FROM arvotut_erat";
$stmt = $pdo->prepare($query);
$stmt->execute();
$eras = $stmt->fetchAll(PDO::FETCH_ASSOC);

$judges = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $era_numero = $_POST['era_numero'];
    $vaihe = $_POST['vaihe'];

    try {
        $pdo->beginTransaction();

        $resetAllQuery = "UPDATE arvotut_erat SET rataid = NULL";
        $pdo->exec($resetAllQuery);

        $query = "SELECT joukkue_id FROM arvotut_erat WHERE era_numero = :era_numero AND vaihe = :vaihe";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':era_numero' => $era_numero, ':vaihe' => $vaihe]);
        $teams = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $rataId = 1;
        foreach ($teams as $joukkue_id) {
            if ($rataId > 6) break;
            $updateQuery = "UPDATE arvotut_erat SET rataid = :rataid WHERE joukkue_id = :joukkue_id AND era_numero = :era_numero AND vaihe = :vaihe";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute([
                ':rataid' => $rataId,
                ':joukkue_id' => $joukkue_id,
                ':era_numero' => $era_numero,
                ':vaihe' => $vaihe
            ]);
            $rataId++;
        }

        $pdo->commit();

        $query = "SELECT ae.joukkue_id, j.nimi AS joukkue_nimi, ae.tuomari_id, t.kayttajanimi AS tuomari_nimi, ae.rataid
                  FROM arvotut_erat ae
                  JOIN joukkueet j ON ae.joukkue_id = j.joukkueid
                  LEFT JOIN kayttajat t ON ae.tuomari_id = t.id
                  WHERE ae.era_numero = :era_numero AND ae.vaihe = :vaihe";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':era_numero' => $era_numero, ':vaihe' => $vaihe]);
        $judges = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Database error: " . $e->getMessage();
    }
}
?>
<div class="container">
    <h1>Ajan aloitus</h1>

    <form method="post" id="eraForm">
        <div class="mb-3">
            <label for="era_numero" class="form-label">Valitse Erä Numero</label>
            <select id="era_numero" name="era_numero" class="form-select" required>
                <option value="">- Valitse Erä Numero -</option>
                <?php foreach ($eras as $era): ?>
                    <option value="<?= htmlspecialchars($era['era_numero']) ?>" 
                            data-vaihe="<?= htmlspecialchars($era['vaihe']) ?>" 
                            <?= (isset($_POST['era_numero']) && $_POST['era_numero'] == $era['era_numero'] && $_POST['vaihe'] == $era['vaihe']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($era['era_numero']) ?> - <?= htmlspecialchars($era['vaihe']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

        </div>
        <input type="hidden" id="vaihe" name="vaihe" value="<?= isset($_POST['vaihe']) ? htmlspecialchars($_POST['vaihe']) : '' ?>">
        <button type="submit" class="btn btn-primary">Näytä Tuomarit</button>
    </form>

    <?php if (!empty($judges)): ?>
        <div class="alert alert-info mt-3">
            <strong>Valittu Erä:</strong> <span id="selected-era"><?= htmlspecialchars($era_numero) ?></span> | 
            <strong>Vaihe:</strong> <span id="selected-vaihe"><?= htmlspecialchars($vaihe) ?></span>
        </div>
    <?php endif; ?>

    <?php if (!empty($judges)): ?>
        <h2>Tuomarit ja Radat</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Joukkue</th>
                    <th>Tuomari</th>
                    <th>Rata</th>
                    <th>Valmius</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($judges as $judge): ?>
                    <tr>
                        <td><?= htmlspecialchars($judge['joukkue_nimi']) ?></td>
                        <td><?= htmlspecialchars($judge['tuomari_nimi'] ?: 'Ei valittu') ?></td>
                        <td><?= htmlspecialchars($judge['rataid'] ?: 'Ei määritelty') ?></td>
                        <td id="status-<?= htmlspecialchars($judge['rataid']) ?>">-</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <button id="startAllBtn" class="btn btn-success" disabled>Aloita Ajanotto</button>
    <button id="resetAllBtn" class="btn btn-danger">Nollaa Radat</button>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/lataa_tuomarit.js"></script>
<script src="js/rc.js"></script>

<?php include_once 'inc/footer.php'; ?>
