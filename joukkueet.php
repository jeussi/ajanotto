<?php 
require_once 'inc/header.php';
require_once 'inc/functions.php';

if (!tarkistaRooli('sihteeri') && !tarkistaRooli('admin')) {
  header("Location: index.php");
  exit;
}
?>

<div class="container">
  <div class="row">
    <h2>Käyttäjätiedot</h2>
  </div>

  <div class="row">
    <p>
      <a href="lisaa_joukkue.php" class="btn btn-success">Lisää joukkue</a>
    </p>
  </div>

  <div class="row">
    <table class="table table-striped">
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
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nimi']; ?></td>
            <td><?php echo $row['koulu']; ?></td>
            <td><?php echo $row['jasen1'] . ', ' . $row['jasen2'] . ', ' . $row['jasen3']; ?></td>
            <td>
              <a href="paivita_joukkue.php?joukkueID=<?php echo $row['id']; ?>" class="btn btn-primary">Päivitä</a>
              <a href="poista_joukkue.php?joukkueID=<?php echo $row['id']; ?>" class="btn btn-danger">Poista</a>
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

<?php 
include_once 'inc/footer.php';
?>