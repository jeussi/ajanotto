
<?php
    require 'database.php';
    header('Content-Type: application/json');

    if (!isset($_GET['era_numero']) || !isset($_GET['vaihe'])) {
        echo json_encode(["error" => "Missing parameters"]);
        exit;
    }

    $era_numero = $_GET['era_numero'];
    $vaihe = $_GET['vaihe'];

    try {
        $query = "SELECT ae.rataid, j.nimi AS joukkue_nimi, 
                        COALESCE(t.kayttajanimi, 'Ei valittu') AS tuomari_nimi,
                        r.valmis
                FROM arvotut_erat ae
                JOIN joukkueet j ON ae.joukkue_id = j.joukkueid
                LEFT JOIN kayttajat t ON ae.tuomari_id = t.id
                LEFT JOIN rata r ON ae.rataid = r.rataid
                WHERE ae.era_numero = :era_numero 
                    AND ae.vaihe = :vaihe
                    AND ae.rataid IS NOT NULL
                ORDER BY ae.rataid ASC";

        $stmt = $pdo->prepare($query);
        $stmt->execute([':era_numero' => $era_numero, ':vaihe' => $vaihe]);
        $judges = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($judges);

    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
?>
