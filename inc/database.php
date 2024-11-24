<?php

try {
  $pdo = new PDO("mysql:host=localhost; dbname=ajanottojarjestelma",
   "ajanottojarjestelma", "vPsANk@pMB636pi9");

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("ERROR: ei voitu yhdistää tietokantaan." . $e->getMessage() );
}