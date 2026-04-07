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

    public function getAlleLeden()
    {
        $sql = "SELECT id, volledige_naam FROM view_leden_overzicht ORDER BY volledige_naam ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAlleLessen()
    {
        $sql = "SELECT id, naam, datum, tijd FROM lessen_nieuw WHERE is_actief = b'1' ORDER BY datum ASC, tijd ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function reserveringBestaat($lidId, $lesId)
    {
        $sql = "SELECT id FROM reserveringen_nieuw WHERE lid_id = :lid_id AND les_id = :les_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':lid_id', $lidId, PDO::PARAM_INT);
        $stmt->bindValue(':les_id', $lesId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch() !== false;
    }

    public function voegReserveringToe($lidId, $lesId)
    {
        $sql = "INSERT INTO reserveringen_nieuw (lid_id, les_id, reserveringsstatus)
                VALUES (:lid_id, :les_id, 'actief')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':lid_id', $lidId, PDO::PARAM_INT);
        $stmt->bindValue(':les_id', $lesId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getReserveringById($id)
    {
        $sql = "SELECT id, lid_id, les_id, reserveringsstatus
                FROM reserveringen_nieuw
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function wijzigReservering($id, $lidId, $lesId, $status)
    {
        $sql = "UPDATE reserveringen_nieuw
                SET lid_id = :lid_id,
                    les_id = :les_id,
                    reserveringsstatus = :status
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':lid_id', $lidId, PDO::PARAM_INT);
        $stmt->bindValue(':les_id', $lesId, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function verwijderReservering($id)
    {
        $sql = "DELETE FROM reserveringen_nieuw WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAantalPerPeriode($vanDatum, $totDatum)
    {
        $sql = "SELECT l.datum, COUNT(r.id) AS aantal
                FROM reserveringen_nieuw r
                INNER JOIN lessen_nieuw l ON r.les_id = l.id
                WHERE l.datum BETWEEN :van AND :tot
                GROUP BY l.datum
                ORDER BY l.datum ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':van', $vanDatum, PDO::PARAM_STR);
        $stmt->bindValue(':tot', $totDatum, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
