CREATE DATABASE IF NOT EXISTS fitforfun;
USE fitforfun;

-- Rollen
CREATE TABLE IF NOT EXISTS rollen (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(50) NOT NULL,
    is_actief BIT(1) NOT NULL DEFAULT b'1'
);

INSERT INTO rollen (naam) VALUES
('beheerder'),
('medewerker'),
('lid');

-- Gebruikers
CREATE TABLE IF NOT EXISTS gebruikers (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    rol_id INT NOT NULL,
    voornaam VARCHAR(50) NOT NULL,
    tussenvoegsel VARCHAR(20) DEFAULT NULL,
    achternaam VARCHAR(50) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    wachtwoord VARCHAR(255) NOT NULL,
    is_ingelogd BIT(1) NOT NULL DEFAULT b'0',
    is_actief BIT(1) NOT NULL DEFAULT b'1',
    opmerking TEXT DEFAULT NULL,
    ingelogd_op DATETIME DEFAULT NULL,
    uitgelogd_op DATETIME DEFAULT NULL,
    FOREIGN KEY (rol_id) REFERENCES rollen(id)
);

INSERT INTO gebruikers (rol_id, voornaam, achternaam, email, wachtwoord) VALUES
(1, 'Admin', 'Beheerder', 'admin@fitforfun.nl', '$2y$10$wXJ8dG6r4V0nXlK5r8kQ0e0Y7M7I8WJ2kYq3wWQ1wDkKjDq8r5Y4C');

-- Medewerkers
CREATE TABLE IF NOT EXISTS medewerkers (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    gebruiker_id INT NOT NULL,
    medewerkersoort VARCHAR(50) NOT NULL,
    telefoonnummer VARCHAR(20) DEFAULT NULL,
    is_actief BIT(1) NOT NULL DEFAULT b'1',
    FOREIGN KEY (gebruiker_id) REFERENCES gebruikers(id)
);

-- Leden
CREATE TABLE IF NOT EXISTS leden_nieuw (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    gebruiker_id INT NOT NULL,
    mobiel VARCHAR(20) DEFAULT NULL,
    relatienummer VARCHAR(20) DEFAULT NULL,
    is_actief BIT(1) NOT NULL DEFAULT b'1',
    FOREIGN KEY (gebruiker_id) REFERENCES gebruikers(id)
);

-- Lessen
CREATE TABLE IF NOT EXISTS lessen_nieuw (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(100) NOT NULL,
    prijs DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    datum DATE NOT NULL,
    tijd TIME NOT NULL,
    min_aantal_personen INT NOT NULL DEFAULT 1,
    max_aantal_personen INT NOT NULL DEFAULT 20,
    status VARCHAR(25) NOT NULL DEFAULT 'Gepland',
    is_aanbieding BIT(1) NOT NULL DEFAULT b'0',
    is_actief BIT(1) NOT NULL DEFAULT b'1',
    opmerking TEXT DEFAULT NULL
);

-- Reserveringen
CREATE TABLE IF NOT EXISTS reserveringen_nieuw (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    lid_id INT NOT NULL,
    les_id INT NOT NULL,
    reserveringsstatus VARCHAR(25) NOT NULL DEFAULT 'actief',
    aangemaakt_op DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Views
CREATE OR REPLACE VIEW view_accounts_overzicht AS
SELECT
    g.id,
    CONCAT(g.voornaam, IF(g.tussenvoegsel IS NOT NULL AND g.tussenvoegsel != '', CONCAT(' ', g.tussenvoegsel), ''), ' ', g.achternaam) AS volledige_naam,
    g.email,
    r.naam AS rol,
    g.is_actief
FROM gebruikers g
INNER JOIN rollen r ON g.rol_id = r.id;

CREATE OR REPLACE VIEW view_medewerker_overzicht AS
SELECT
    m.id,
    CONCAT(g.voornaam, IF(g.tussenvoegsel IS NOT NULL AND g.tussenvoegsel != '', CONCAT(' ', g.tussenvoegsel), ''), ' ', g.achternaam) AS volledige_naam,
    m.medewerkersoort,
    g.email,
    m.telefoonnummer,
    m.is_actief
FROM medewerkers m
INNER JOIN gebruikers g ON m.gebruiker_id = g.id;

CREATE OR REPLACE VIEW view_leden_overzicht AS
SELECT
    l.id,
    CONCAT(g.voornaam, IF(g.tussenvoegsel IS NOT NULL AND g.tussenvoegsel != '', CONCAT(' ', g.tussenvoegsel), ''), ' ', g.achternaam) AS volledige_naam,
    g.email,
    l.mobiel,
    l.relatienummer,
    l.is_actief
FROM leden_nieuw l
INNER JOIN gebruikers g ON l.gebruiker_id = g.id;

CREATE OR REPLACE VIEW view_geplande_lessen AS
SELECT id, naam, datum, tijd, prijs, status
FROM lessen_nieuw
WHERE is_actief = b'1' AND datum >= CURDATE();

CREATE OR REPLACE VIEW view_reservering_overzicht AS
SELECT
    r.id,
    CONCAT(g.voornaam, ' ', g.achternaam) AS lid_naam,
    l.naam AS les_naam,
    l.datum,
    l.tijd,
    r.reserveringsstatus
FROM reserveringen_nieuw r
INNER JOIN leden_nieuw ln ON r.lid_id = ln.id
INNER JOIN gebruikers g ON ln.gebruiker_id = g.id
INNER JOIN lessen_nieuw l ON r.les_id = l.id;
