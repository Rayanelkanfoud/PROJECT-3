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

    public function voegLidToe($voornaam, $tussenvoegsel, $achternaam, $email, $wachtwoord, $mobiel, $relatienummer)
    {
        // Voeg gebruiker toe
        $sql = "INSERT INTO gebruikers (voornaam, tussenvoegsel, achternaam, email, wachtwoord, rol_id, is_actief)
                VALUES (:voornaam, :tussenvoegsel, :achternaam, :email, :wachtwoord, 3, b'1')";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':voornaam',      $voornaam,      PDO::PARAM_STR);
        $stmt->bindValue(':tussenvoegsel', $tussenvoegsel, PDO::PARAM_STR);
        $stmt->bindValue(':achternaam',    $achternaam,    PDO::PARAM_STR);
        $stmt->bindValue(':email',         $email,         PDO::PARAM_STR);
        $stmt->bindValue(':wachtwoord',    $wachtwoord,    PDO::PARAM_STR);
        $stmt->execute();

        $gebruikerId = $this->db->lastInsertId();

        // Voeg lid toe
        $sql2 = "INSERT INTO leden (gebruiker_id, mobiel, relatienummer, is_actief)
                 VALUES (:gebruiker_id, :mobiel, :relatienummer, b'1')";

        $stmt2 = $this->db->prepare($sql2);
        $stmt2->bindValue(':gebruiker_id',  $gebruikerId,   PDO::PARAM_INT);
        $stmt2->bindValue(':mobiel',        $mobiel,        PDO::PARAM_STR);
        $stmt2->bindValue(':relatienummer', $relatienummer, PDO::PARAM_STR);

        return $stmt2->execute();
    }

    public function emailBestaat($email)
    {
        $sql = "SELECT id FROM gebruikers WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch() !== false;
    }
}