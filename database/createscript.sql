CREATE DATABASE IF NOT EXISTS fitforfun;
USE fitforfun;

CREATE TABLE gebruikers (
    Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    Email VARCHAR(150) NOT NULL UNIQUE,
    Wachtwoord VARCHAR(255) NOT NULL,
    Rol VARCHAR(50) NOT NULL DEFAULT 'gebruiker',
    AangemaaktOp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO gebruikers (Naam, Email, Wachtwoord, Rol)
VALUES (
    'Test Gebruiker',
    'test@test.nl',
    '$2y$10$wXJ8dG6r4V0nXlK5r8kQ0e0Y7M7I8WJ2kYq3wWQ1wDkKjDq8r5Y4C',
    'admin'
);