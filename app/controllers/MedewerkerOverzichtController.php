<?php
require_once '../app/models/Medewerker.php';

$testUnhappy = false;

$succesmelding = '';
$foutmelding   = '';

$voornaam        = '';
$tussenvoegsel   = '';
$achternaam      = '';
$email           = '';
$wachtwoord      = '';
$medewerkersoort = '';
$telefoonnummer  = '';

try {
    $medewerkerModel = new Medewerker();

    // Formulier verwerken
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $voornaam        = trim($_POST['voornaam']        ?? '');
        $tussenvoegsel   = trim($_POST['tussenvoegsel']   ?? '');
        $achternaam      = trim($_POST['achternaam']      ?? '');
        $email           = trim($_POST['email']           ?? '');
        $wachtwoord      = $_POST['wachtwoord']           ?? '';
        $medewerkersoort = trim($_POST['medewerkersoort'] ?? '');
        $telefoonnummer  = trim($_POST['telefoonnummer']  ?? '');

        // Validatie
        if ($voornaam === '' || $achternaam === '' || $email === '' || $wachtwoord === '' || $medewerkersoort === '') {
            $foutmelding = 'Vul alle verplichte velden in.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $foutmelding = 'Vul een geldig e-mailadres in.';
        } elseif (strlen($wachtwoord) < 8) {
            $foutmelding = 'Het wachtwoord moet minimaal 8 tekens bevatten.';
        } elseif ($medewerkerModel->emailBestaat($email)) {
            $foutmelding = 'Dit e-mailadres is al in gebruik.';
        } else {
            $wachtwoordHash = password_hash($wachtwoord, PASSWORD_DEFAULT);
            $gelukt = $medewerkerModel->voegMedewerkerToe(
                $voornaam, $tussenvoegsel, $achternaam, $email,
                $wachtwoordHash, $medewerkersoort, $telefoonnummer
            );

            if ($gelukt) {
                $succesmelding = 'De medewerker is succesvol opgeslagen.';
                $voornaam = $tussenvoegsel = $achternaam = $email = $wachtwoord = $medewerkersoort = $telefoonnummer = '';
            } else {
                $foutmelding = 'De medewerker kon niet worden opgeslagen.';
            }
        }
    }

    if ($testUnhappy) {
        $medewerkers = [];
    } else {
        $medewerkers = $medewerkerModel->getAlleMedewerkers();
    }

    if (!empty($medewerkers) || $succesmelding !== '' || $foutmelding !== '' || $_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once '../app/views/medewerkeroverzicht/index.php';
    } elseif (empty($medewerkers)) {
        require_once '../app/views/medewerkeroverzicht/index.php';
    } else {
        require_once '../app/views/medewerkeroverzicht/fout.php';
    }
}