<?php
include_once 'inc/header.php';
include_once 'inc/database.php';
include_once 'inc/functions.php';

if (!tarkistaRooli('admin')) {
  header("Location: index.php");
  exit;
}

$kayttajaID = null;
$kayttajanimi = '';
$rooli = '';
$error = '';

if (!empty($_GET['kayttajaID'])) {
    $kayttajaID = $_GET['kayttajaID'];
} else {
    header("Location: kayttajat.php");
    exit;
}

if ($kayttajaID) {
    $sql = "SELECT * FROM kayttajat WHERE id = :kayttajaID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':kayttajaID', $kayttajaID, PDO::PARAM_INT);
    $stmt->execute();
    $kayttaja = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$kayttaja) {
        header("Location: kayttajat.php");
        exit;
    }

    $kayttajanimi = $kayttaja['kayttajanimi'];
    $rooli = $kayttaja['rooli'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kayttajanimi = $_POST['kayttajanimi'];
    $rooli = $_POST['rooli'];

    if (empty($kayttajanimi)) {
        $error = 'Käyttäjänimi ei voi olla tyhjä.';
    } else {
        $sql = "UPDATE kayttajat SET kayttajanimi = :kayttajanimi, rooli = :rooli WHERE id = :kayttajaID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':kayttajanimi', $kayttajanimi, PDO::PARAM_STR);
        $stmt->bindParam(':rooli', $rooli, PDO::PARAM_STR);
        $stmt->bindParam(':kayttajaID', $kayttajaID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: kayttajat.php");
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
                <h2>Päivitä käyttäjätiedot</h2>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="paivita_kayttaja.php?kayttajaID=<?php echo $kayttajaID; ?>" method="POST">
                    <div class="mb-3">
                        <label for="kayttajanimi" class="form-label">Käyttäjänimi</label>
                        <input type="text" id="kayttajanimi" name="kayttajanimi" value="<?php echo $kayttajanimi; ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rooli" class="form-label">Rooli</label>
                        <select id="rooli" name="rooli" class="form-control">
                            <option value="admin" <?php echo $rooli === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="sihteeri" <?php echo $rooli === 'sihteeri' ? 'selected' : ''; ?>>Sihteeri</option>
                            <option value="tuomari" <?php echo $rooli === 'tuomari' ? 'selected' : ''; ?>>Tuomari</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Päivitä</button>
                    <a href="kayttajat.php" class="btn btn-secondary">Takaisin</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'inc/footer.php'; ?>
