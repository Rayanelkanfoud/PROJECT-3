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

    public function voegMedewerkerToe($voornaam, $tussenvoegsel, $achternaam, $email, $wachtwoord, $medewerkersoort, $telefoonnummer)
    {
        // Voeg gebruiker toe
        $sql = "INSERT INTO gebruikers (voornaam, tussenvoegsel, achternaam, email, wachtwoord, rol_id, is_actief)
                VALUES (:voornaam, :tussenvoegsel, :achternaam, :email, :wachtwoord, 2, b'1')";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':voornaam',      $voornaam,      PDO::PARAM_STR);
        $stmt->bindValue(':tussenvoegsel', $tussenvoegsel, PDO::PARAM_STR);
        $stmt->bindValue(':achternaam',    $achternaam,    PDO::PARAM_STR);
        $stmt->bindValue(':email',         $email,         PDO::PARAM_STR);
        $stmt->bindValue(':wachtwoord',    $wachtwoord,    PDO::PARAM_STR);
        $stmt->execute();

        $gebruikerId = $this->db->lastInsertId();

        // Voeg medewerker toe
        $sql2 = "INSERT INTO medewerkers (gebruiker_id, medewerkersoort, telefoonnummer, is_actief)
                 VALUES (:gebruiker_id, :medewerkersoort, :telefoonnummer, b'1')";

        $stmt2 = $this->db->prepare($sql2);
        $stmt2->bindValue(':gebruiker_id',    $gebruikerId,    PDO::PARAM_INT);
        $stmt2->bindValue(':medewerkersoort', $medewerkersoort, PDO::PARAM_STR);
        $stmt2->bindValue(':telefoonnummer',  $telefoonnummer,  PDO::PARAM_STR);

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