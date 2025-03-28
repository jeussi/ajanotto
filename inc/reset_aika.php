
<?php
    require 'database.php';

    try {
        $query = "UPDATE rata SET valmis = 0, aika_aloitettu = 0 WHERE rataid IS NOT NULL";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        echo json_encode(["status" => "success"]);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
?>
