<?php
require_once __DIR__ . '/../config/database.php';

class Database
{
    private $verbinding;

    public function __construct()
    {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAAM . ';charset=utf8mb4';
            $this->verbinding = new PDO($dsn, DB_GEBRUIKER, DB_WACHTWOORD);
            $this->verbinding->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Databaseverbinding mislukt: ' . $e->getMessage());
        }
    }

    public function getVerbinding()
    {
        return $this->verbinding;
    }
}