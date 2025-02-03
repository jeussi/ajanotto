<?php
include_once 'inc/header.php';
include_once 'inc/functions.php';

if (!tarkistaRooli('sihteeri') && !tarkistaRooli('admin')) {
  header("Location: index.php");
  exit;
}
?>

<div class="container">
  <div class="row">
    <div class="col-8 mx-auto tausta">
      <div class="row">
        <h2>Joukkuetiedot</h2>
      </div>

      <div class="row mt-2">
        <p>
          <a href="lisaa_joukkue.php" class="btn btn-success">Lisää joukkue</a>
        </p>
      </div>

      <div class="row">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nimi</th>
              <th>Koulu</th>
              <th>Jäsenet</th>
            </tr>
          </thead>
          <tbody>
            <?php

            require_once 'inc/database.php';
            $sql = "SELECT * FROM joukkueet";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()) :
            ?>
              <tr>
                <td><?php echo $row['joukkueid']; ?></td>
                <td><?php echo $row['nimi']; ?></td>
                <td><?php echo $row['koulu']; ?></td>
                <td><?php echo $row['jasen1'] . ', ' . $row['jasen2'] . ', ' . $row['jasen3']; ?></td>
                <td>
                  <a href="paivita_joukkue.php?joukkueID=<?php echo $row['joukkueid']; ?>" class="btn btn-primary float-end">Päivitä</a>
                  <a href="poista_joukkue.php?joukkueID=<?php echo $row['joukkueid']; ?>" class="btn btn-danger float-end">Poista</a>
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