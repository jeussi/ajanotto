<?php
include_once 'inc/header.php';
include_once 'inc/database.php';
include_once 'inc/functions.php';

if (!tarkistaRooli('sihteeri') && !tarkistaRooli('admin')) {
    header("Location: index.php");
    exit;
  }

$joukkueID = null;
$nimi = '';
$koulu = '';
$jasen1 = '';
$jasen2 = '';
$jasen3 = '';
$error = '';

if (!empty($_GET['joukkueID'])) {
    $joukkueID = $_GET['joukkueID'];
} else {
    header("Location: joukkueet.php");
    exit;
}

if ($joukkueID) {
    $sql = "SELECT * FROM joukkueet WHERE id = :joukkueID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':joukkueID', $joukkueID, PDO::PARAM_INT);
    $stmt->execute();
    $joukkue = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$joukkue) {
        header("Location: joukkueet.php");
        exit;
    }

    $nimi = $joukkue['nimi'];
    $koulu = $joukkue['koulu'];
    $jasen1 = $joukkue['jasen1'];
    $jasen2 = $joukkue['jasen2'];
    $jasen3 = $joukkue['jasen3'];
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nimi = $_POST['nimi'];
    $koulu = $_POST['koulu'];
    $jasen1 = $_POST['jasen1'];
    $jasen2 = $_POST['jasen2'];
    $jasen3 = $_POST['jasen3'];
    

    if (empty($nimi) || empty($koulu) || empty($jasen1) || empty($jasen2) || empty($jasen3)) {
        $error = 'Kaikki kentät ovat pakollisia.';
    } else {
        $sql = "UPDATE joukkueet SET nimi = :nimi, koulu = :koulu, jasen1 = :jasen1, jasen2 = :jasen2,
        jasen3 = :jasen3 WHERE id = :joukkueID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nimi', $nimi, PDO::PARAM_STR);
        $stmt->bindParam(':koulu', $koulu, PDO::PARAM_STR);
        $stmt->bindParam(':jasen1', $jasen1, PDO::PARAM_STR);
        $stmt->bindParam(':jasen2', $jasen2, PDO::PARAM_STR);
        $stmt->bindParam(':jasen3', $jasen3, PDO::PARAM_STR);
        $stmt->bindParam(':joukkueID', $joukkueID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: joukkueet.php");
            exit;
        } else {
            $error = 'Tietojen päivittäminen epäonnistui.';
        }
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-8 mx-auto">
            <div class="tausta mt-3">
                <h2>Päivitä joukkuetiedot</h2>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="paivita_joukkue.php?joukkueID=<?php echo $joukkueID; ?>" method="POST">
                    <div class="mb-3">
                        <label for="nimi" class="form-label">Nimi</label>
                        <input type="text" id="nimi" name="nimi" value="<?php echo $nimi; ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="koulu" class="form-label">Koulu</label>
                        <input type="text" id="koulu" name="koulu" value="<?php echo $koulu; ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jasen1" class="form-label">Jäsen 1</label>
                        <input type="text" id="jasen1" name="jasen1" value="<?php echo $jasen1; ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jasen2" class="form-label">Jäsen 2</label>
                        <input type="text" id="jasen2" name="jasen2" value="<?php echo $jasen2; ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jasen3" class="form-label">Jäsen 3</label>
                        <input type="text" id="jasen3" name="jasen3" value="<?php echo $jasen3; ?>" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Päivitä</button>
                    <a href="joukkueet.php" class="btn btn-secondary">Takaisin</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'inc/footer.php'; ?>
