<?php
require_once __DIR__ . '/../libraries/Database.php';

class Lid
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getVerbinding();
    }

    public function getAlleLeden()
    {
        $sql = "SELECT id, volledige_naam, email, mobiel, relatienummer, is_actief
                FROM view_leden_overzicht
                ORDER BY volledige_naam ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}