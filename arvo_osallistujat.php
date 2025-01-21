<?php
include_once 'inc/header.php';
include_once 'inc/functions.php';
include_once 'inc/database.php';

if (!tarkistaKirjautuminen()){
   header("Location: index.php");
   exit;
 }
?>



<div class="container">
  <form method="post" action="arvo_osallistujat.php">
    <label for="vaihe">Valitse vaihe:</label>
    <select name="vaihe" id="vaihe" required>
      <option value="alkuera">Alkuerä</option>
      <option value="valiera">Välierä</option>
    </select>

    <label for="joukkueet">Valitse joukkueet:</label>

    <button type="submit">Arvo listat</button>
  </form>
</div>