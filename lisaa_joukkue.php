<?php
include_once 'inc/database.php';
include_once 'inc/header.php';

if (!tarkistaRooli('sihteeri') && !tarkistaRooli('admin')) {
  header("Location: index.php");
  exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nimi = $_POST['nimi'];
  $koulu = $_POST['koulu'];
  $jasen1 = $_POST['jasen1'];
  $jasen2 = $_POST['jasen2'];
  $jasen3 = $_POST['jasen3'];

  if (empty($nimi) || empty($koulu) || empty($jasen1) || empty($jasen2) || empty($jasen3)) {
    $error = 'Kaikki kentät ovat pakollisia.';
  } else {
    $sql = "INSERT INTO joukkueet (nimi, koulu, jasen1, jasen2, jasen3) VALUES (:nimi, :koulu, :jasen1, :jasen2, :jasen3)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nimi', $nimi, PDO::PARAM_STR);
    $stmt->bindParam(':koulu', $koulu, PDO::PARAM_STR);
    $stmt->bindParam(':jasen1', $jasen1, PDO::PARAM_STR);
    $stmt->bindParam(':jasen2', $jasen2, PDO::PARAM_STR);
    $stmt->bindParam(':jasen3', $jasen3, PDO::PARAM_STR);

    if ($stmt->execute()) {
      $success = 'Joukkue lisätty onnistuneesti.';
    } else {
      $error = 'Joukkueen lisääminen epäonnistui.';
    }
  }
}

?>

<div class="container">
  <div class="row">
    <div class="col-8 mx-auto">
      <div class="tausta mt-3">
        <h2>Lisää joukkue</h2>
        <?php if ($error): ?>
          <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
          <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="post">
          <div class="mb-3">
            <label for="nimi" class="form-label">Joukkueen nimi</label>
            <input type="text" class="form-control" id="nimi" name="nimi" required>
          </div>
          <div class="mb-3">
            <label for="koulu" class="form-label">Koulu</label>
            <input type="text" class="form-control" id="koulu" name="koulu" required>
          </div>
          <div class="mb-3">
            <label for="jasen1" class="form-label">Jäsen 1</label>
            <input type="text" class="form-control" id="jasen1" name="jasen1" required>
          </div>
          <div class="mb-3">
            <label for="jasen2" class="form-label">Jäsen 2</label>
            <input type="text" class="form-control" id="jasen2" name="jasen2" required>
          </div>
          <div class="mb-3">
            <label for="jasen3" class="form-label">Jäsen 3</label>
            <input type="text" class="form-control" id="jasen3" name="jasen3" required>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-success">Tallenna</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once 'inc/footer.php'; ?>