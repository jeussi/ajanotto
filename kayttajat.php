<?php
include_once 'inc/header.php';
include_once 'inc/functions.php';

if (!tarkistaRooli('admin')) {
  header("Location: index.php");
  exit;
}
?>

<div class="container">
  <div class="row">
    <div class="col-10 mx-auto tausta">
      <div class="row">
        <h2>Käyttäjätiedot</h2>
      </div>

      <div class="row mt-2">
        <p>
          <a href="lisaa_kayttaja.php" class="btn btn-success">Lisää käyttäjä</a>
        </p>
      </div>

      <div class="row">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Käyttäjänimi</th>
              <th>salasana</th>
              <th>Rooli</th>
            </tr>
          </thead>
          <tbody>
            <?php

            require_once 'inc/database.php';
            $sql = "SELECT * FROM kayttajat";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()) :
            ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['kayttajanimi']; ?></td>
                <td><?php echo $row['salasana']; ?></td>
                <td><?php echo $row['rooli']; ?></td>
                <td>
                  <a href="paivita_kayttaja.php?kayttajaID=<?php echo $row['id']; ?>" class="btn btn-primary float-end">Päivitä</a>
                  <a href="poista_kayttaja.php?kayttajaID=<?php echo $row['id']; ?>" class="btn btn-danger float-end">Poista</a>
                </td>
              </tr>
            <?php endwhile;
            unset($result);
            unset($pdo);
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
include_once 'inc/footer.php';
?>