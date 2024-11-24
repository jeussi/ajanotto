<?php
include_once 'inc/header.php';
include_once 'inc/database.php';


if ($_SERVER['REQUEST_METHOD'] == "POST") {

  //luetaan tiedot lomakkeelta
  $kayttajanimi = $_POST['kayttajanimi'];
  $salasana = $_POST['salasana'];

  //alustetaan virheilmoitukset
  $kayttajanimiError = '';
  $salasanaError = '';

  //oletetaan että tiedot on syötetty oikein
  $valid = true;

  if (empty($kayttajanimi)) {
    $valid = false;
    $kayttajanimiError = 'Syötä käyttäjänimi';
  }

  if (empty($salasana)) {
    $valid = false;
    $salasanaError = 'Syötä salasana';
  }

  if ($valid) {
    $sql = "SELECT id, salasana
          FROM kayttajat
          WHERE kayttajanimi = :kayttajanimi";

    $stmt = $pdo->prepare($sql);
    $stmt->bindPARAM(':kayttajanimi', $kayttajanimi, PDO::PARAM_STR);
    $stmt->execute();

    $kayttaja = $stmt->fetch(PDO::FETCH_OBJ);

    //tarkistetaan että salasana on oikein

    if ($kayttaja && password_verify($salasana, $kayttaja->salasana)) {

      $_SESSION['kirjautunut'] = true;
      $_SESSION['id'] = $kayttaja->id;
      $_SESSION['kayttajanimi'] = $kayttajanimi;

      header("Location: lisaa_joukkue.php");
      exit;
    } else {
      $salasanaError = 'Tarkista salasana';
      $kayttajanimiError = 'Tarkista käyttäjätunnus';
    }
  }
}
?>

<div class="container">
  <div class="row">
    <div class="col-8 mx-auto">
      <div class="card card-body bg-light mt-3">
        <h2>Kirjaudu sisään</h2>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="mb-3">
            <label for="kayttajanimi" class="form-label">Käyttäjänimi</label>
            <input type="text" value="<?php echo (!empty($kayttajanimi)) ? $kayttajanimi : ''; ?>" class="form-control
            <?php echo (!empty($kayttajanimiError)) ? 'is-invalid' : ''; ?>" id="kayttajanimi" name="kayttajanimi" required>
            <div class="invalid-feedback">
              <small><?php echo $kayttajanimiError; ?></small>
            </div>
          </div>

          <div class="mb-3">
            <label for="salasana" class="form-label">Salasana</label>
            <input type="password" class="form-control <?php echo (!empty($salasanaError)) ? 'is-invalid' : ''; ?>" id="salasana"
              value="<?php echo (!empty($salasana)) ? $salasana : ''; ?>" name="salasana" required>
            <div class="invalid-feedback">
              <small><?php echo $salasanaError; ?></small>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-success">Kirjaudu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once 'inc/footer.php'; ?>