<?php
/**
 * Model: Medewerker — beheert medewerkers in de tabel accounts (Rol = 'medewerker')
 */
class Medewerker
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /** Geeft alle medewerkers terug */
    public function getAll()
    {
        $this->db->query("SELECT * FROM accounts WHERE Rol = 'medewerker' ORDER BY Naam ASC");
        return $this->db->resultSet();
    }

    /** Voegt een nieuwe medewerker toe — geeft true/false terug */
    public function create($data)
    {
        $this->db->query(
            "INSERT INTO accounts (Naam, Email, Wachtwoord, Rol, Status)
             VALUES (:naam, :email, :wachtwoord, 'medewerker', :status)"
        );
        $this->db->bind(':naam',       $data['naam'],       PDO::PARAM_STR);
        $this->db->bind(':email',      $data['email'],      PDO::PARAM_STR);
        $this->db->bind(':wachtwoord', $data['wachtwoord'], PDO::PARAM_STR);
        $this->db->bind(':status',     $data['status'],     PDO::PARAM_STR);
        return $this->db->execute();
    }

    /** Controleert of e-mail al bestaat in accounts */
    public function emailBestaat($email)
    {
        $this->db->query("SELECT Id FROM accounts WHERE Email = :email");
        $this->db->bind(':email', $email, PDO::PARAM_STR);
        return $this->db->single() ? true : false;
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