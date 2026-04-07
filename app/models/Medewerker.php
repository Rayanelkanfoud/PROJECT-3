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
        try {
            $this->db->beginTransaction();

            $hashedWachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

            $sql = "INSERT INTO gebruikers 
                    (voornaam, tussenvoegsel, achternaam, email, wachtwoord, rol_id, is_actief)
                    VALUES 
                    (:voornaam, :tussenvoegsel, :achternaam, :email, :wachtwoord, 2, b'1')";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':voornaam', $voornaam, PDO::PARAM_STR);
            $stmt->bindValue(':tussenvoegsel', $tussenvoegsel, PDO::PARAM_STR);
            $stmt->bindValue(':achternaam', $achternaam, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':wachtwoord', $hashedWachtwoord, PDO::PARAM_STR);
            $stmt->execute();

            $gebruikerId = $this->db->lastInsertId();

            $sql2 = "INSERT INTO medewerkers 
                     (gebruiker_id, medewerkersoort, telefoonnummer, is_actief)
                     VALUES 
                     (:gebruiker_id, :medewerkersoort, :telefoonnummer, b'1')";

            $stmt2 = $this->db->prepare($sql2);
            $stmt2->bindValue(':gebruiker_id', $gebruikerId, PDO::PARAM_INT);
            $stmt2->bindValue(':medewerkersoort', $medewerkersoort, PDO::PARAM_STR);
            $stmt2->bindValue(':telefoonnummer', $telefoonnummer, PDO::PARAM_STR);
            $stmt2->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return false;
        }
    }

    public function emailBestaat($email)
    {
        $sql = "SELECT id FROM gebruikers WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch() !== false;
    }

    public function getMedewerkerById($id)
    {
        $sql = "SELECT m.id, g.id AS gebruiker_id,
                       g.voornaam, g.tussenvoegsel, g.achternaam,
                       g.email, m.medewerkersoort, m.telefoonnummer
                FROM medewerkers m
                INNER JOIN gebruikers g ON g.id = m.gebruiker_id
                WHERE m.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function wijzigMedewerker($medewerkerID, $voornaam, $tussenvoegsel, $achternaam, $email, $medewerkersoort, $telefoonnummer)
    {
        try {
            $this->db->beginTransaction();

            $sqlGebruiker = "UPDATE gebruikers
                             SET voornaam = :voornaam,
                                 tussenvoegsel = :tussenvoegsel,
                                 achternaam = :achternaam,
                                 email = :email
                             WHERE id = (SELECT gebruiker_id FROM medewerkers WHERE id = :medewerker_id)";

            $stmt = $this->db->prepare($sqlGebruiker);
            $stmt->bindValue(':voornaam', $voornaam, PDO::PARAM_STR);
            $stmt->bindValue(':tussenvoegsel', $tussenvoegsel, PDO::PARAM_STR);
            $stmt->bindValue(':achternaam', $achternaam, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':medewerker_id', $medewerkerID, PDO::PARAM_INT);
            $stmt->execute();

            $sqlMedewerker = "UPDATE medewerkers
                              SET medewerkersoort = :medewerkersoort,
                                  telefoonnummer = :telefoonnummer
                              WHERE id = :id";

            $stmt2 = $this->db->prepare($sqlMedewerker);
            $stmt2->bindValue(':medewerkersoort', $medewerkersoort, PDO::PARAM_STR);
            $stmt2->bindValue(':telefoonnummer', $telefoonnummer, PDO::PARAM_STR);
            $stmt2->bindValue(':id', $medewerkerID, PDO::PARAM_INT);
            $stmt2->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return false;
        }
    }
}