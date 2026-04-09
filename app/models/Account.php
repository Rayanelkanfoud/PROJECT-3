<?php
require_once __DIR__ . '/../libraries/Database.php';

class Account
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getVerbinding();
    }

    public function getAlleAccounts()
    {
        $sql = "SELECT id, volledige_naam, email, rol, is_actief
                FROM view_accounts_overzicht
                ORDER BY volledige_naam ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAlleRollen()
    {
        $sql = "SELECT id, naam
                FROM rollen
                WHERE is_actief = b'1'
                ORDER BY naam ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function emailBestaatAl($email)
    {
        $sql = "SELECT id
                FROM gebruikers
                WHERE email = :email
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function voegAccountToe($rolId, $voornaam, $tussenvoegsel, $achternaam, $email, $wachtwoord, $opmerking)
    {
        $sql = "INSERT INTO gebruikers
                (rol_id, voornaam, tussenvoegsel, achternaam, email, wachtwoord, is_ingelogd, is_actief, opmerking)
                VALUES
                (:rol_id, :voornaam, :tussenvoegsel, :achternaam, :email, :wachtwoord, b'0', b'1', :opmerking)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':rol_id', $rolId, PDO::PARAM_INT);
        $stmt->bindValue(':voornaam', $voornaam, PDO::PARAM_STR);
        $stmt->bindValue(':tussenvoegsel', $tussenvoegsel, PDO::PARAM_STR);
        $stmt->bindValue(':achternaam', $achternaam, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':wachtwoord', $wachtwoord, PDO::PARAM_STR);
        $stmt->bindValue(':opmerking', $opmerking, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function verwijderAccount($id)
    {
        $sql = "DELETE FROM gebruikers WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getAccountById($id)
    {
        $sql = "SELECT g.id, g.rol_id, g.voornaam, g.tussenvoegsel, g.achternaam, g.email, g.opmerking
                FROM gebruikers g
                WHERE g.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function wijzigAccount($id, $rolId, $voornaam, $tussenvoegsel, $achternaam, $email, $opmerking)
    {
        $sql = "UPDATE gebruikers
                SET rol_id = :rol_id,
                    voornaam = :voornaam,
                    tussenvoegsel = :tussenvoegsel,
                    achternaam = :achternaam,
                    email = :email,
                    opmerking = :opmerking
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':rol_id', $rolId, PDO::PARAM_INT);
        $stmt->bindValue(':voornaam', $voornaam, PDO::PARAM_STR);
        $stmt->bindValue(':tussenvoegsel', $tussenvoegsel, PDO::PARAM_STR);
        $stmt->bindValue(':achternaam', $achternaam, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':opmerking', $opmerking, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}