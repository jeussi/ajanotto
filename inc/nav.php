<?php 
require_once 'functions.php';
include_once 'header.php'; 
?>


<nav class="navbar navbar-expand-lg navbg mb-3">
  <div class="container">
    <a class="navbar-brand" href="index.php">Ajanottojärjestelmä</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if (tarkistaKirjautuminen()) : ?>
          <?php if (!tarkistaRooli('tuomari')) : ?>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="lisaa_joukkue.php">Lisää joukkue</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="joukkueet.php">Joukkueet</a>
            </li>
          <?php endif; ?>
          <?php if (!tarkistaRooli('sihteeri')) : ?>
            <li class="nav-item">
              <a class="nav-link" href="ajanotto.php">Ajanotto</a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link" href="tulospalvelu.php">Tulospalvelu</a>
          </li>
          <?php if (tarkistaRooli('admin')) : ?>
            <li class="nav-item">
              <a class="nav-link" href="lisaa_kayttaja.php">Lisää käyttäjä</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="kayttajat.php">Käyttäjät</a>
            </li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>
      <?php if (tarkistaKirjautuminen()) : ?>
        <a class="nav-link" href="ulos.php">Log out <i class="bi bi-box-arrow-right"></i></a>
      <?php else : ?>
        <a class="nav-link" href="kirjaudu.php">Log in <i class="bi bi-box-arrow-in-right"></i></a>
      <?php endif; ?>
    </div>
  </div>
</nav>