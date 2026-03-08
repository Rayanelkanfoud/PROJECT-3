<?php
require_once __DIR__ . '/../libraries/Database.php';

class Reservering
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getVerbinding();
    }

    public function getAlleReserveringen()
    {
        $sql = "SELECT id, lid_naam, les_naam, datum, tijd, reserveringsstatus
                FROM view_reservering_overzicht
                ORDER BY datum ASC, tijd ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}