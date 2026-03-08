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
}