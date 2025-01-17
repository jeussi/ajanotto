<?php

function tarkistaKirjautuminen()
{

  if (isset($_SESSION['kirjautunut']) && $_SESSION['kirjautunut'] === true) {
    return true;
  } else {
    return false;
  }
}

function tarkistaRooli($vaadittuRooli)
{
  if (isset($_SESSION['kirjautunut']) && $_SESSION['kirjautunut'] === true) {
    return isset($_SESSION['rooli']) && strtolower($_SESSION['rooli']) === strtolower($vaadittuRooli);
  }
  return false;
}
