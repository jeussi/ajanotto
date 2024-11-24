<?php

function tarkistaKirjautuminen()
{

  if (isset($_SESSION['kirjautunut']) && $_SESSION['kirjautunut'] === true) {
    return true;
  } else {
    return false;
  }
}
