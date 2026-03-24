<?php
/**
 * Model: Lid — beheert alle CRUD-operaties voor de tabel leden
 */
class Lid
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /** Geeft alle leden terug */
    public function getAll()
    {
        $this->db->query("SELECT * FROM leden ORDER BY Achternaam ASC");
        return $this->db->resultSet();
    }

    /** Zoek op achternaam */
    public function zoekOpAchternaam($zoek)
    {
        $this->db->query("SELECT * FROM leden WHERE Achternaam LIKE :zoek ORDER BY Achternaam ASC");
        $this->db->bind(':zoek', '%' . $zoek . '%', PDO::PARAM_STR);
        return $this->db->resultSet();
    }

    /** Geeft één lid terug op Id */
    public function getById($id)
    {
        $this->db->query("SELECT * FROM leden WHERE Id = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    /** Voegt een nieuw lid toe — geeft true/false terug */
    public function create($data)
    {
        $this->db->query(
            "INSERT INTO leden (Voornaam, Achternaam, Email, Telefoon, LidSinds, Status)
             VALUES (:voornaam, :achternaam, :email, :telefoon, :lidsinds, :status)"
        );
        $this->db->bind(':voornaam',   $data['voornaam'],   PDO::PARAM_STR);
        $this->db->bind(':achternaam', $data['achternaam'], PDO::PARAM_STR);
        $this->db->bind(':email',      $data['email'],      PDO::PARAM_STR);
        $this->db->bind(':telefoon',   $data['telefoon'],   PDO::PARAM_STR);
        $this->db->bind(':lidsinds',   $data['lidsinds'],   PDO::PARAM_STR);
        $this->db->bind(':status',     $data['status'],     PDO::PARAM_STR);
        return $this->db->execute();
    }

    /** Past een bestaand lid aan */
    public function update($id, $data)
    {
        $this->db->query(
            "UPDATE leden
             SET Voornaam = :voornaam, Achternaam = :achternaam, Email = :email,
                 Telefoon = :telefoon, LidSinds = :lidsinds, Status = :status,
                 DatumGewijzigd = NOW(6)
             WHERE Id = :id"
        );
        $this->db->bind(':voornaam',   $data['voornaam'],   PDO::PARAM_STR);
        $this->db->bind(':achternaam', $data['achternaam'], PDO::PARAM_STR);
        $this->db->bind(':email',      $data['email'],      PDO::PARAM_STR);
        $this->db->bind(':telefoon',   $data['telefoon'],   PDO::PARAM_STR);
        $this->db->bind(':lidsinds',   $data['lidsinds'],   PDO::PARAM_STR);
        $this->db->bind(':status',     $data['status'],     PDO::PARAM_STR);
        $this->db->bind(':id',         $id,                 PDO::PARAM_INT);
        return $this->db->execute();
    }

    /** Verwijdert een lid op Id */
    public function delete($id)
    {
        $this->db->query("DELETE FROM leden WHERE Id = :id");
        $this->db->bind(':id', $id, PDO::PARAM_INT);
        return $this->db->execute();
    }

    /** Controleert of e-mail al bestaat (optioneel: sluit huidig id uit) */
    public function emailBestaat($email, $uitgeslotenId = null)
    {
        if ($uitgeslotenId) {
            $this->db->query("SELECT Id FROM leden WHERE Email = :email AND Id != :id");
            $this->db->bind(':id', $uitgeslotenId, PDO::PARAM_INT);
        } else {
            $this->db->query("SELECT Id FROM leden WHERE Email = :email");
        }
        $this->db->bind(':email', $email, PDO::PARAM_STR);
        return $this->db->single() ? true : false;
    }
}
