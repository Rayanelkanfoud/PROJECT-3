<?php
require_once '../app/models/Medewerker.php';

$succesmelding = '';
$foutmelding   = '';

$voornaam        = '';
$tussenvoegsel   = '';
$achternaam      = '';
$email           = '';
$wachtwoord      = '';
$medewerkersoort = '';
$telefoonnummer  = '';

// Gegevens voor het wijzigingsformulier (pre-ingevuld via context menu)
$wijzigMedewerker = null;

try {
    $medewerkerModel = new Medewerker();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $actie = trim($_POST['actie'] ?? '');

        if ($actie === 'verwijder_medewerker') {
            // Happy scenario: medewerker verwijderen bevestigd
            $verwijderId = (int)($_POST['verwijder_id'] ?? 0);
            if ($verwijderId > 0) {
                $gelukt = $medewerkerModel->verwijderMedewerker($verwijderId);
                if ($gelukt) {
                    $succesmelding = 'De medewerker is succesvol verwijderd.';
                } else {
                    $foutmelding = 'De medewerker kon niet worden verwijderd.';
                }
            }

        } elseif ($actie === 'annuleer_verwijder') {
            // Unhappy scenario: verwijdering geannuleerd
            $foutmelding = 'Het verwijderen is geannuleerd.';

        } elseif ($actie === 'laad_wijzig') {
            // Context menu: open wijzig-modal met huidige medewerkergegevens
            $medewerkerID = (int)($_POST['medewerker_id'] ?? 0);
            if ($medewerkerID > 0) {
                $wijzigMedewerker = $medewerkerModel->getMedewerkerById($medewerkerID);
            }

        } elseif ($actie === 'wijzig') {
            // Formulier ingediend vanuit wijzig-modal
            $medewerkerID    = (int)($_POST['medewerker_id'] ?? 0);
            $voornaam        = trim($_POST['voornaam']        ?? '');
            $tussenvoegsel   = trim($_POST['tussenvoegsel']   ?? '');
            $achternaam      = trim($_POST['achternaam']      ?? '');
            $email           = trim($_POST['email']           ?? '');
            $medewerkersoort = trim($_POST['medewerkersoort'] ?? '');
            $telefoonnummer  = trim($_POST['telefoonnummer']  ?? '');

            if ($voornaam === '' || $achternaam === '' || $email === '' || $medewerkersoort === '') {
                // Unhappy scenario: verplichte velden ontbreken
                $foutmelding = 'Vul alle verplichte velden in.';
                $wijzigMedewerker = [
                    'id'             => $medewerkerID,
                    'voornaam'       => $voornaam,
                    'tussenvoegsel'  => $tussenvoegsel,
                    'achternaam'     => $achternaam,
                    'email'          => $email,
                    'medewerkersoort'=> $medewerkersoort,
                    'telefoonnummer' => $telefoonnummer,
                ];
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $foutmelding = 'Vul een geldig e-mailadres in.';
                $wijzigMedewerker = [
                    'id'             => $medewerkerID,
                    'voornaam'       => $voornaam,
                    'tussenvoegsel'  => $tussenvoegsel,
                    'achternaam'     => $achternaam,
                    'email'          => $email,
                    'medewerkersoort'=> $medewerkersoort,
                    'telefoonnummer' => $telefoonnummer,
                ];
            } else {
                $gelukt = $medewerkerModel->wijzigMedewerker(
                    $medewerkerID, $voornaam, $tussenvoegsel,
                    $achternaam, $email, $medewerkersoort, $telefoonnummer
                );

                if ($gelukt) {
                    // Happy scenario: medewerker succesvol gewijzigd
                    $succesmelding = 'De medewerker is succesvol gewijzigd.';
                } else {
                    $foutmelding = 'De medewerker kon niet worden gewijzigd. Probeer het opnieuw.';
                }
            }

        } else {
            // Nieuwe medewerker toevoegen
            $voornaam        = trim($_POST['voornaam']        ?? '');
            $tussenvoegsel   = trim($_POST['tussenvoegsel']   ?? '');
            $achternaam      = trim($_POST['achternaam']      ?? '');
            $email           = trim($_POST['email']           ?? '');
            $wachtwoord      = $_POST['wachtwoord']           ?? '';
            $medewerkersoort = trim($_POST['medewerkersoort'] ?? '');
            $telefoonnummer  = trim($_POST['telefoonnummer']  ?? '');

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
                    $foutmelding = 'De medewerker kon niet worden opgeslagen. Probeer het opnieuw.';
                }
            }
        }
    }

    $medewerkers = $medewerkerModel->getAlleMedewerkers();

    require_once '../app/views/medewerkeroverzicht/index.php';
} catch (Exception $e) {
    require_once '../app/views/medewerkeroverzicht/fout.php';
}
