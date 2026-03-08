<?php
require_once __DIR__ . '/../libraries/Database.php';

class Medewerker
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getVerbinding();
    }

    public function getAlleMedewerkers()
    {
        $sql = "SELECT id, volledige_naam, medewerkersoort, email, telefoonnummer, is_actief
                FROM view_medewerker_overzicht
                ORDER BY volledige_naam ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}