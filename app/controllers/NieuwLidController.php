<?php
require_once '../app/models/Lid.php';

$succesmelding = '';
$foutmelding   = '';

$voornaam      = '';
$tussenvoegsel = '';
$achternaam    = '';
$email         = '';
$wachtwoord    = '';
$mobiel        = '';
$relatienummer = '';

try {
    $lidModel = new Lid();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $voornaam      = trim($_POST['voornaam']      ?? '');
        $tussenvoegsel = trim($_POST['tussenvoegsel'] ?? '');
        $achternaam    = trim($_POST['achternaam']    ?? '');
        $email         = trim($_POST['email']         ?? '');
        $wachtwoord    = $_POST['wachtwoord']         ?? '';
        $mobiel        = trim($_POST['mobiel']        ?? '');
        $relatienummer = trim($_POST['relatienummer'] ?? '');

        // Validatie
        if ($voornaam === '' || $achternaam === '' || $email === '' || $wachtwoord === '') {
            $foutmelding = 'Vul alle verplichte velden in.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $foutmelding = 'Vul een geldig e-mailadres in.';
        } elseif (strlen($wachtwoord) < 8) {
            $foutmelding = 'Het wachtwoord moet minimaal 8 tekens bevatten.';
        } elseif ($lidModel->emailBestaat($email)) {
            $foutmelding = 'Dit e-mailadres is al in gebruik.';
        } else {
            $wachtwoordHash = password_hash($wachtwoord, PASSWORD_DEFAULT);
            $gelukt = $lidModel->voegLidToe(
                $voornaam, $tussenvoegsel, $achternaam, $email,
                $wachtwoordHash, $mobiel, $relatienummer
            );

            if ($gelukt) {
                $succesmelding = 'Het lid is succesvol opgeslagen.';
                $voornaam = $tussenvoegsel = $achternaam = $email = $wachtwoord = $mobiel = $relatienummer = '';
            } else {
                $foutmelding = 'Het lid kon niet worden opgeslagen.';
            }
        }
    }

    require_once '../app/views/nieuwlid/index.php';
} catch (Exception $e) {
    require_once '../app/views/nieuwlid/fout.php';
}
