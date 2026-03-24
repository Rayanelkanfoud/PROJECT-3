<?php
require_once __DIR__ . '/../libraries/Database.php';

class LedenPerPeriode
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getVerbinding();
    }

    public function getAantalLedenPerPeriode($periode)
    {
        $sql = "SELECT COUNT(*) AS totaal
                FROM leden
                WHERE DATE_FORMAT(datum_aangemaakt, '%Y-%m') = :periode";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':periode', $periode, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBeschikbarePeriodes()
    {
        $sql = "SELECT DATE_FORMAT(datum_aangemaakt, '%Y-%m') AS periode
                FROM leden
                GROUP BY DATE_FORMAT(datum_aangemaakt, '%Y-%m')
                ORDER BY periode DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}