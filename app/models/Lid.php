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

    public function zoekOpAchternaam($zoekterm)
    {
        $sql = "SELECT
                    l.id,
                    g.voornaam,
                    g.tussenvoegsel,
                    g.achternaam,
                    g.email,
                    l.mobiel,
                    l.relatienummer,
                    l.is_actief
                FROM leden l
                INNER JOIN gebruikers g ON l.gebruiker_id = g.id
                WHERE g.achternaam LIKE :zoekterm
                ORDER BY g.achternaam ASC, g.voornaam ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':zoekterm', '%' . $zoekterm . '%', PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}