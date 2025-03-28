
<?php
    include_once 'database.php';

    $query = "SELECT COUNT(*) AS valmis_count FROM rata WHERE valmis = TRUE";
    $result = $pdo->prepare($query);
    $result->execute();

    $row = $result->fetch(PDO::FETCH_ASSOC);

    echo json_encode(["valmis_count" => $row['valmis_count']]);
?>
