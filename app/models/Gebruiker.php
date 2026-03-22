<?php
require_once __DIR__ . '/../libraries/Database.php';

class Gebruiker
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getVerbinding();
    }

    public function login($email, $wachtwoord)
    {
        $sql = "SELECT id, rol_id, voornaam, tussenvoegsel, achternaam, email, wachtwoord
                FROM gebruikers
                WHERE email = :email
                AND is_actief = b'1'
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($gebruiker && $gebruiker['wachtwoord'] === $wachtwoord) {
            return $gebruiker;
        }

        return false;
    }

    public function zetOpIngelogd($id)
    {
        $sql = "UPDATE gebruikers
                SET is_ingelogd = b'1',
                    ingelogd_op = NOW(),
                    uitgelogd_op = NULL
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function zetOpUitgelogd($id)
    {
        $sql = "UPDATE gebruikers
                SET is_ingelogd = b'0',
                    uitgelogd_op = NOW()
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}