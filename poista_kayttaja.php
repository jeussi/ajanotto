<?php
require_once "inc/database.php";

if (!empty($_POST)) {
    $kayttajaID = $_POST['kayttajaID'];

    $sql = "DELETE FROM kayttajat WHERE id = :kayttajaID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':kayttajaID', $kayttajaID, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: kayttajat.php");
    exit;
} else {
    $kayttajaID = null;

    if (!empty($_GET['kayttajaID'])) {
        $kayttajaID = $_REQUEST['kayttajaID'];
    }

    if ($kayttajaID == null) {
        header("Location: kayttajat.php");
        exit;
    }

    $sql = "SELECT id, kayttajanimi, rooli FROM kayttajat WHERE id = :kayttajaID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':kayttajaID', $kayttajaID, PDO::PARAM_INT);
    $stmt->execute();

    $kayttaja = $stmt->fetch(PDO::FETCH_OBJ);

    if ($kayttaja === false) {
        header("Location: kayttajat.php");
        exit;
    }
}
?>

<?php include_once 'inc/header.php'; ?>

<div class="container text-center">
    <div class="card card-body bg-light mt-3">
        <h3>Käyttäjän poistaminen</h3>
        <p>Haluatko varmasti poistaa käyttäjän <strong><?php echo $kayttaja->kayttajanimi; ?></strong>?</p>
        <form action="poista_kayttaja.php" method="post">
            <input type="hidden" name="kayttajaID" value="<?php echo $kayttaja->id; ?>">
            <button type="submit" class="btn btn-danger">Poista</button>
            <a href="kayttajat.php" class="btn btn-secondary">Takaisin</a>
        </form>
    </div>
</div>

<?php 
include_once 'inc/footer.php'; 
?>
