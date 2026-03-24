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
}