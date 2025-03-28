
<?php
    require 'database.php';

    try {
        $query = "UPDATE rata SET aika_aloitettu = 1 WHERE rataid IS NOT NULL";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        echo json_encode(["status" => "success"]);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
?>
