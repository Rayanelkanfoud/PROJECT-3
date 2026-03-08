<?php
require_once __DIR__ . '/../libraries/Database.php';

class GeplandeLes
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getVerbinding();
    }

    public function getAlleGeplandeLessen()
    {
        $sql = "SELECT id, naam, datum, tijd, prijs, status
                FROM view_geplande_lessen
                ORDER BY datum ASC, tijd ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}