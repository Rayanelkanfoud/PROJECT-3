-- Step: 01
-- ************************************************************
-- Doel : Maak een nieuwe database aan met de naam MVC_Basics_2509AB
-- ************************************************************
--
-- Versie   Datum       Auteur            Omschrijving
-- 01       10-02-2026  Arjan de Ruijter   Smartphones
--
-- ************************************************************

-- Verwijder database MVC_Basics_2509AB
DROP DATABASE IF EXISTS `MVC_Basics_2509AB`;

-- Maak een nieuwe database aan MVC_Basics_2509AB
CREATE DATABASE `MVC_Basics_2509AB`;

-- Gebruik database MVC_Basics_2509AB
USE `MVC_Basics_2509AB`;



-- Step: 02
-- ************************************************************
-- Doel : Maak een nieuwe tabel aan met de naam Smartphones
-- ************************************************************
--
-- Versie   Datum       Auteur            Omschrijving
-- 01       10-02-2026  Arjan de Ruijter   Tabel Smartphones
--
-- ************************************************************
--
-- Onderstaande velden toevoegen aan de tabel Smartphones
-- Merk, Model, Prijs, Geheugen, Besturingssysteem,
-- Schermgrootte, Releasedatum, MegaPixels
-- ************************************************************

CREATE TABLE Smartphones
(
    Id                SMALLINT        UNSIGNED    NOT NULL    AUTO_INCREMENT,
    Merk              VARCHAR(50)                 NOT NULL,
    Model             VARCHAR(50)                 NOT NULL,
    Prijs             DECIMAL(6,2)                NOT NULL,
    Geheugen          DECIMAL(4,0)                NOT NULL,
    Besturingssysteem VARCHAR(25)                 NOT NULL,
    Schermgrootte     DECIMAL(3,2)                NOT NULL,
    Releasedatum      DATE                        NOT NULL,
    MegaPixels        DECIMAL(3,0)                NOT NULL,
    IsActief          BIT                         NOT NULL    DEFAULT 1,
    Opmerking         VARCHAR(255)                            DEFAULT NULL,
    DatumAangemaakt   DATETIME(6)                 NOT NULL    DEFAULT NOW(6),
    DatumGewijzigd    DATETIME(6)                 NOT NULL    DEFAULT NOW(6),
    CONSTRAINT PK_Smartphones_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;



-- Step: 03
-- ************************************************************
-- Doel : Vul de tabel Smartphones met gegevens
-- ************************************************************
--
-- Versie   Datum       Auteur            Omschrijving
-- 01       10-02-2026  Arjan de Ruijter   Vulling Smartphones
--
-- ************************************************************

INSERT INTO Smartphones
(
    Merk,
    Model,
    Prijs,
    Geheugen,
    Besturingssysteem,
    Schermgrootte,
    Releasedatum,
    MegaPixels
)
VALUES
('Apple',   'iPhone 16 Pro',        1256.56,   64, 'iOS 18',      6.7, '2025-01-19',  50),
('Samsung', 'Galaxy S25 Ultra',     1539.00,  128, 'Android 15',  6.1, '2025-02-01', 200),
('Google',  'Pixel 9 Pro',           890.00, 1024, 'Android 15',  6.3, '2024-12-20', 100),

-- Extra records (minimaal 5)
('OnePlus', 'OnePlus 12',            899.00,  256, 'Android 14',  6.8, '2024-01-23',  50),
('Xiaomi',  'Xiaomi 14 Pro',         900.00,  256, 'Android 14',  7.2, '2030-01-23',  60),
('Apple',   'iPhone 15',            1099.00,  128, 'iOS 17',      6.1, '2024-09-22',  48),
('Samsung', 'Galaxy A55',            479.00,  128, 'Android 14',  6.6, '2024-03-11',  64),
('Sony',    'Xperia 1 VI',          1299.00,  256, 'Android 14',  6.5, '2024-05-10',  48);



-- Step: 04
-- ************************************************************
-- Doel : Maak een nieuwe tabel aan met de naam Sneakers
-- ************************************************************
--
-- Versie   Datum       Auteur            Omschrijving
-- 01       10-02-2026  Arjan de Ruijter   Tabel Sneakers
--
-- ************************************************************
--
-- Onderstaande velden toevoegen aan de tabel Sneakers
-- Type (Hardloop, Basketbal, Casual),
-- Prijs, Materiaal (Leer, Mesh, Synthetisch),
-- Gewicht, Releasedatum
-- ************************************************************

CREATE TABLE Sneakers
(
    Id               SMALLINT        UNSIGNED    NOT NULL    AUTO_INCREMENT,
    Merk             VARCHAR(50)                 NOT NULL,
    Model            VARCHAR(50)                 NOT NULL,
    Type             VARCHAR(25)                 NOT NULL,
    Prijs            DECIMAL(6,2)                NOT NULL,
    Materiaal        VARCHAR(25)                 NOT NULL,
    Gewicht          DECIMAL(5,2)                NOT NULL,
    Releasedatum     DATE                        NOT NULL,
    IsActief         BIT                         NOT NULL    DEFAULT 1,
    Opmerking        VARCHAR(255)                            DEFAULT NULL,
    DatumAangemaakt  DATETIME(6)                 NOT NULL    DEFAULT NOW(6),
    DatumGewijzigd   DATETIME(6)                 NOT NULL    DEFAULT NOW(6),
    CONSTRAINT PK_Sneakers_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;



-- Step: 05
-- ************************************************************
-- Doel : Vul de tabel Sneakers met gegevens
-- ************************************************************
--
-- Versie   Datum       Auteur            Omschrijving
-- 01       10-02-2026  Arjan de Ruijter   Vulling Sneakers
--
-- ************************************************************

INSERT INTO Sneakers
(
    Merk,
    Model,
    Type,
    Prijs,
    Materiaal,
    Gewicht,
    Releasedatum
)
VALUES
('Nike',        'Air Jordan 1',      'Basketbal', 189.99, 'Leer',        1.25, '2024-03-01'),
('Adidas',      'Yeezy Boost 350',   'Casual',    229.99, 'Mesh',        1.10, '2023-11-15'),
('New Balance', '990v6',             'Hardloop',  219.99, 'Synthetisch', 1.30, '2024-01-20'),
('Puma',        'RS-X',              'Casual',    119.99, 'Mesh',        1.05, '2023-09-10'),
('Asics',       'Gel-Kayano 30',     'Hardloop',  199.99, 'Synthetisch', 1.20, '2024-02-05');



-- Checks (controle)
SELECT * FROM Smartphones;
SELECT * FROM Sneakers;

-- Step: 06
-- ************************************************************
-- Doel : Vul de tabel Horloges met gegevens
-- ************************************************************
--
-- Versie   Datum       Auteur            Omschrijving
-- 01       10-02-2026  Arjan de Ruijter  Horloges
--
-- ************************************************************

CREATE TABLE Horloges
(
    Id               SMALLINT        UNSIGNED    NOT NULL    AUTO_INCREMENT,
    Merk             VARCHAR(50)                 NOT NULL,
    Model            VARCHAR(50)                 NOT NULL,
    Prijs            DECIMAL(6,2)                NOT NULL,
    Materiaal        VARCHAR(25)                 NOT NULL,
    Gewicht          DECIMAL(6,2)                NOT NULL,
    Releasedatum     DATE                        NOT NULL,
    IsActief         BIT                         NOT NULL    DEFAULT 1,
    Opmerking        VARCHAR(255)                            DEFAULT NULL,
    DatumAangemaakt  DATETIME(6)                 NOT NULL    DEFAULT NOW(6),
    DatumGewijzigd   DATETIME(6)                 NOT NULL    DEFAULT NOW(6),
    CONSTRAINT PK_Horloges_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;

INSERT INTO Horloges
(
    Merk, Model, Prijs, Materiaal, Gewicht, Releasedatum
)
VALUES
('Apple',   'Watch Series 9',      449.00, 'Aluminium', 38.50,  '2023-09-22'),
('Samsung', 'Galaxy Watch 6',      329.00, 'Aluminium', 33.00,  '2023-08-11'),
('Garmin',  'Forerunner 965',      599.00, 'Kunststof', 52.00,  '2023-03-01'),
('Casio',   'G-Shock GA-2100',     119.00, 'Resin',     51.00,  '2021-06-01'),
('Seiko',   '5 Sports SRPD55',     299.00, 'Staal',     105.00, '2020-01-15');