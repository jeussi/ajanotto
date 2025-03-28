
<?php
    require 'database.php';

    $query = "SELECT MAX(aika_aloitettu) AS aika_aloitettu FROM rata WHERE rataid IS NOT NULL";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(["aika_aloitettu" => (bool)$result['aika_aloitettu']]);
?>
