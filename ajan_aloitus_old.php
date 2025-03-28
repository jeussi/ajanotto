<?php
include_once 'inc/header.php';
include_once 'inc/database.php';
include_once 'inc/functions.php';

if (!tarkistaRooli('sihteeri') && !tarkistaRooli('admin')) {
    header("Location: index.php");
    exit;
}   
?>
<head>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="containerajat">
        <div class="d-flex">
            <div id="rata-1" class="boxajat"></div>
            <div id="rata-2" class="boxajat"></div>
            <div id="rata-3" class="boxajat"></div>
            <div id="rata-4" class="boxajat"></div>
            <div id="rata-5" class="boxajat"></div>
            <div id="rata-6" class="boxajat"></div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/rc.js"></script>
    <script src="js/lataa_tuomarit.js"></script>
</body>