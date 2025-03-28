
<?php
    include_once 'database.php'; 

    if (isset($_POST['rataid'])) {
        $rataid = $_POST['rataid'];

        try {
            $query = "UPDATE rata SET valmis = TRUE WHERE rataid = :rataid";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':rataid' => $rataid]);

            echo json_encode(['status' => 'success', 'message' => 'Rata on nyt valmis']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Rataid puuttuu']);
    }
?>
