<?php
include_once 'inc/header.php'; 
include_once 'inc/database.php'; 
include_once 'inc/functions.php';

if (!tarkistaRooli('admin')) {
  header("Location: index.php");
  exit;
}

$kayttajanimiError = $salasanaError = $rooliError = '';
$kayttajanimi = $salasana = $rooli = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kayttajanimi = trim($_POST['kayttajanimi']);
    $salasana = trim($_POST['salasana']);
    $rooli = trim($_POST['rooli']);

    $valid = true;

    if (empty($kayttajanimi)) {
        $kayttajanimiError = 'Käyttäjänimi on pakollinen.';
        $valid = false;
    }
    if (empty($salasana)) {
        $salasanaError = 'Salasana on pakollinen.';
        $valid = false;
    }
    if (empty($rooli) || !in_array($rooli, ['admin', 'sihteeri', 'tuomari'])) {
        $rooliError = 'Valitse kelvollinen rooli.';
        $valid = false;
    }

    if ($valid) {
        $salasanaHash = password_hash($salasana, PASSWORD_DEFAULT);

        $sql = "INSERT INTO kayttajat (kayttajanimi, salasana, rooli) VALUES (:kayttajanimi, :salasana, :rooli)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':kayttajanimi', $kayttajanimi, PDO::PARAM_STR);
        $stmt->bindParam(':salasana', $salasanaHash, PDO::PARAM_STR);
        $stmt->bindParam(':rooli', $rooli, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: kayttajat.php"); //OHJATAAN KÄYTTÄJÄLISTA.PHP SIVULLE
            exit;
        } else {
            echo "Käyttäjän lisääminen epäonnistui.";
        }
    }
}
?>

<div class="container tausta">
    <h2>Lisää uusi käyttäjä</h2>
    <form action="lisaa_kayttaja.php" method="POST">
        <div class="mb-3">
            <label for="kayttajanimi" class="form-label">Käyttäjänimi</label>
            <input type="text" name="kayttajanimi" class="form-control <?php echo (!empty($kayttajanimiError)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($kayttajanimi); ?>">
            <div class="invalid-feedback"><?php echo $kayttajanimiError; ?></div>
        </div>
        <div class="mb-3">
            <label for="salasana" class="form-label">Salasana</label>
            <input type="password" name="salasana" class="form-control <?php echo (!empty($salasanaError)) ? 'is-invalid' : ''; ?>">
            <div class="invalid-feedback"><?php echo $salasanaError; ?></div>
        </div>
        <div class="mb-3">
            <label for="rooli" class="form-label">Rooli</label>
            <select name="rooli" class="form-control <?php echo (!empty($rooliError)) ? 'is-invalid' : ''; ?>">
                <option value="">Valitse rooli</option>
                <option value="admin" <?php echo ($rooli == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="sihteeri" <?php echo ($rooli == 'sihteeri') ? 'selected' : ''; ?>>Sihteeri</option>
                <option value="tuomari" <?php echo ($rooli == 'tuomari') ? 'selected' : ''; ?>>Tuomari</option>
            </select>
            <div class="invalid-feedback"><?php echo $rooliError; ?></div>
        </div>
        <button type="submit" class="btn btn-success">Lisää käyttäjä</button>
    </form>
</div>
<?php include_once 'inc/footer.php'; ?>
