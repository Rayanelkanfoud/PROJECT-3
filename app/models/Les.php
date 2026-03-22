<?php
require_once __DIR__ . '/../libraries/Database.php';

class Les
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getVerbinding();
    }

    public function getAlleLessen()
    {
        $sql = "SELECT id, naam, prijs, datum, tijd, min_aantal_personen, max_aantal_personen, status, is_aanbieding
                FROM lessen
                ORDER BY datum ASC, tijd ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function zoekOpNaam($zoekterm)
    {
        $sql = "SELECT id, naam, prijs, datum, tijd, status, is_aanbieding
                FROM lessen
                WHERE naam LIKE :zoekterm
                ORDER BY datum ASC, tijd ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':zoekterm', '%' . $zoekterm . '%', PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function voegLesToe($naam, $prijs, $datum, $tijd, $minAantalPersonen, $maxAantalPersonen, $status, $isAanbieding, $opmerking)
    {
        $sql = "INSERT INTO lessen
                (naam, prijs, datum, tijd, min_aantal_personen, max_aantal_personen, status, is_aanbieding, is_actief, opmerking)
                VALUES
                (:naam, :prijs, :datum, :tijd, :min_aantal_personen, :max_aantal_personen, :status, :is_aanbieding, b'1', :opmerking)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':naam', $naam, PDO::PARAM_STR);
        $stmt->bindValue(':prijs', $prijs);
        $stmt->bindValue(':datum', $datum, PDO::PARAM_STR);
        $stmt->bindValue(':tijd', $tijd, PDO::PARAM_STR);
        $stmt->bindValue(':min_aantal_personen', $minAantalPersonen, PDO::PARAM_INT);
        $stmt->bindValue(':max_aantal_personen', $maxAantalPersonen, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':is_aanbieding', $isAanbieding, PDO::PARAM_INT);
        $stmt->bindValue(':opmerking', $opmerking, PDO::PARAM_STR);

        return $stmt->execute();
    }
}