<?php
include_once 'inc/header.php';
include_once 'inc/database.php';
include_once 'inc/functions.php';

if (!tarkistaRooli('sihteeri') && !tarkistaRooli('admin')) {
    header("Location: index.php");
    exit;
  }

if (!empty($_POST)) {
    $joukkueID = $_POST['joukkueID'];

    $sql = "DELETE FROM joukkueet WHERE id = :joukkueID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':joukkueID', $joukkueID, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: joukkueet.php");
    exit;
} else {
    $joukkueID = null;

    if (!empty($_GET['joukkueID'])) {
        $joukkueID = $_REQUEST['joukkueID'];
    }

    if ($joukkueID == null) {
        header("Location: joukkueet.php");
        exit;
    }

    $sql = "SELECT id, nimi, koulu, jasen1, jasen2, jasen3 FROM joukkueet WHERE id = :joukkueID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':joukkueID', $joukkueID, PDO::PARAM_INT);
    $stmt->execute();

    $joukkue = $stmt->fetch(PDO::FETCH_OBJ);

    if ($joukkue === false) {
        header("Location: joukkueet.php");
        exit;
    }
}
?>

<div class="container text-center">
    <div class="tausta mt-3">
        <h3>Joukkueen poistaminen</h3>
        <p>Haluatko varmasti poistaa joukkueen <strong> ID: <?php echo $joukkue->id;?>, <?php echo $joukkue->nimi; ?> </strong>?</p>
        <form action="poista_joukkue.php" method="post">
            <input type="hidden" name="joukkueID" value="<?php echo $joukkue->id; ?>">
            <button type="submit" class="btn btn-danger">Poista</button>
            <a href="joukkueet.php" class="btn btn-secondary">Takaisin</a>
        </form>
    </div>
</div>

<?php 
include_once 'inc/footer.php'; 
?>
