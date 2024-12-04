<?php
session_start();
require_once 'inc/functions.php';
$sivu = basename($_SERVER['PHP_SELF']);
if ($sivu != 'index.php' && $sivu != 'kirjaudu.php') {
  if (!tarkistaKirjautuminen()) {
    header("Location: index.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajanottojarjestelma</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/background.css">
</head>

<body>
  <?php include_once 'nav.php';