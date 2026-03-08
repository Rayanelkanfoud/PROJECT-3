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
}