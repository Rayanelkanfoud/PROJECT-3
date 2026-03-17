<?php

class AuthModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getUserByEmail($email)
    {
        $this->db->query("SELECT * FROM gebruikers WHERE Email = :email");
        $this->db->bind(':email', $email);

        return $this->db->single();
    }
}