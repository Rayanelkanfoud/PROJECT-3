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