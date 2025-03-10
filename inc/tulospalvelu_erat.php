<?php
    include_once 'database.php';

    $era = $_GET['era'] ?? null;

    if ($era) {
        $sql = "SELECT DISTINCT era_numero FROM tulostaulu WHERE era = :era ORDER BY era_numero ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':era' => $era]);

        $era_numerot = "<option value=''>- Valitse eränumero -</option>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $era_numerot .= "<option value='" . $row['era_numero'] . "'>" . $row['era_numero'] . "</option>";
        }

        echo $era_numerot;
    } else {
        echo "<option value=''>- Valitse eränumero -</option>";
    }
?>
