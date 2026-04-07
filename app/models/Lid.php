<?php
require_once __DIR__ . '/../libraries/Database.php';

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

    public function getAlleLeden()
    {
        $sql = "SELECT id, volledige_naam, email, mobiel, relatienummer, is_actief
                FROM view_leden_overzicht
                ORDER BY volledige_naam ASC";

        $stmt = $this->db->getVerbinding()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function voegLidToe($voornaam, $tussenvoegsel, $achternaam, $email, $wachtwoord, $mobiel, $relatienummer)
    {
        $pdo = $this->db->getVerbinding();

        // Voeg gebruiker toe
        $sql = "INSERT INTO gebruikers (voornaam, tussenvoegsel, achternaam, email, wachtwoord, rol_id, is_actief)
                VALUES (:voornaam, :tussenvoegsel, :achternaam, :email, :wachtwoord, 3, b'1')";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':voornaam',      $voornaam,      PDO::PARAM_STR);
        $stmt->bindValue(':tussenvoegsel', $tussenvoegsel, PDO::PARAM_STR);
        $stmt->bindValue(':achternaam',    $achternaam,    PDO::PARAM_STR);
        $stmt->bindValue(':email',         $email,         PDO::PARAM_STR);
        $stmt->bindValue(':wachtwoord',    $wachtwoord,    PDO::PARAM_STR);
        $stmt->execute();

        $gebruikerId = $pdo->lastInsertId();

        // Voeg lid toe
        $sql2 = "INSERT INTO leden_nieuw (gebruiker_id, mobiel, relatienummer, is_actief)
                 VALUES (:gebruiker_id, :mobiel, :relatienummer, b'1')";

        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindValue(':gebruiker_id',  $gebruikerId,   PDO::PARAM_INT);
        $stmt2->bindValue(':mobiel',        $mobiel,        PDO::PARAM_STR);
        $stmt2->bindValue(':relatienummer', $relatienummer, PDO::PARAM_STR);

        return $stmt2->execute();
    }

    public function emailBestaat($email)
    {
        $sql = "SELECT id FROM gebruikers WHERE email = :email";
        $stmt = $this->db->getVerbinding()->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch() !== false;
    }

    public function getLidNieuwById($id)
    {
        $sql = "SELECT l.id, l.gebruiker_id, g.voornaam, g.tussenvoegsel, g.achternaam,
                       g.email, l.mobiel, l.relatienummer
                FROM leden_nieuw l
                INNER JOIN gebruikers g ON g.id = l.gebruiker_id
                WHERE l.id = :id
                LIMIT 1";

        $stmt = $this->db->getVerbinding()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function wijzigLid($lidId, $voornaam, $tussenvoegsel, $achternaam, $email, $mobiel, $relatienummer)
    {
        $pdo = $this->db->getVerbinding();
        try {
            $pdo->beginTransaction();

            $sqlGebruiker = "UPDATE gebruikers
                             SET voornaam = :voornaam,
                                 tussenvoegsel = :tussenvoegsel,
                                 achternaam = :achternaam,
                                 email = :email
                             WHERE id = (SELECT gebruiker_id FROM leden_nieuw WHERE id = :lid_id)";

            $stmt = $pdo->prepare($sqlGebruiker);
            $stmt->bindValue(':voornaam', $voornaam, PDO::PARAM_STR);
            $stmt->bindValue(':tussenvoegsel', $tussenvoegsel, PDO::PARAM_STR);
            $stmt->bindValue(':achternaam', $achternaam, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':lid_id', $lidId, PDO::PARAM_INT);
            $stmt->execute();

            $sqlLid = "UPDATE leden_nieuw
                       SET mobiel = :mobiel,
                           relatienummer = :relatienummer
                       WHERE id = :id";

            $stmt2 = $pdo->prepare($sqlLid);
            $stmt2->bindValue(':mobiel', $mobiel, PDO::PARAM_STR);
            $stmt2->bindValue(':relatienummer', $relatienummer, PDO::PARAM_STR);
            $stmt2->bindValue(':id', $lidId, PDO::PARAM_INT);
            $stmt2->execute();

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            return false;
        }
    }

    public function verwijderLidNieuw($id)
    {
        $pdo = $this->db->getVerbinding();
        try {
            $pdo->beginTransaction();

            $sqlGetId = "SELECT gebruiker_id FROM leden_nieuw WHERE id = :id LIMIT 1";
            $stmt = $pdo->prepare($sqlGetId);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) { $pdo->rollBack(); return false; }

            $gebruikerId = $row['gebruiker_id'];

            $pdo->prepare("DELETE FROM leden_nieuw WHERE id = :id")
                ->execute([':id' => $id]);

            $pdo->prepare("DELETE FROM gebruikers WHERE id = :id")
                ->execute([':id' => $gebruikerId]);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            return false;
        }
    }
}