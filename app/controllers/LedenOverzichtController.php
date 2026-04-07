<?php
require_once '../app/models/Lid.php';

$succesmelding = '';
$foutmelding   = '';
$wijzigLid     = null;

try {
    $lidModel = new Lid();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $actie = trim($_POST['actie'] ?? '');

        if ($actie === 'laad_wijzig') {
            // Context menu: open wijzig-modal met huidige lidgegevens
            $lidId = (int)($_POST['lid_id'] ?? 0);
            if ($lidId > 0) {
                $wijzigLid = $lidModel->getLidNieuwById($lidId);
            }

        } elseif ($actie === 'wijzig') {
            // Wijzigformulier ingediend
            $lidId         = (int)($_POST['lid_id']        ?? 0);
            $voornaam      = trim($_POST['voornaam']        ?? '');
            $tussenvoegsel = trim($_POST['tussenvoegsel']   ?? '');
            $achternaam    = trim($_POST['achternaam']      ?? '');
            $email         = trim($_POST['email']           ?? '');
            $mobiel        = trim($_POST['mobiel']          ?? '');
            $relatienummer = trim($_POST['relatienummer']   ?? '');

            if ($voornaam === '' || $achternaam === '' || $email === '') {
                // Unhappy scenario: verplichte velden ontbreken
                $foutmelding = 'Vul alle verplichte velden in.';
                $wijzigLid = [
                    'id' => $lidId, 'voornaam' => $voornaam,
                    'tussenvoegsel' => $tussenvoegsel, 'achternaam' => $achternaam,
                    'email' => $email, 'mobiel' => $mobiel, 'relatienummer' => $relatienummer,
                ];
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $foutmelding = 'Vul een geldig e-mailadres in.';
                $wijzigLid = [
                    'id' => $lidId, 'voornaam' => $voornaam,
                    'tussenvoegsel' => $tussenvoegsel, 'achternaam' => $achternaam,
                    'email' => $email, 'mobiel' => $mobiel, 'relatienummer' => $relatienummer,
                ];
            } else {
                $gelukt = $lidModel->wijzigLid($lidId, $voornaam, $tussenvoegsel, $achternaam, $email, $mobiel, $relatienummer);
                if ($gelukt) {
                    // Happy scenario
                    $succesmelding = 'Het lid is succesvol gewijzigd.';
                } else {
                    $foutmelding = 'Het lid kon niet worden gewijzigd.';
                }
            }

        } elseif ($actie === 'verwijder') {
            // Happy scenario: lid verwijderen bevestigd
            $lidId = (int)($_POST['verwijder_id'] ?? 0);
            if ($lidId > 0) {
                $gelukt = $lidModel->verwijderLidNieuw($lidId);
                if ($gelukt) {
                    $succesmelding = 'Het lid is succesvol verwijderd.';
                } else {
                    $foutmelding = 'Het lid kon niet worden verwijderd.';
                }
            }

        } elseif ($actie === 'annuleer_verwijder') {
            // Unhappy scenario: verwijdering geannuleerd
            $foutmelding = 'Het verwijderen is geannuleerd.';
        }
    }

    $leden = $lidModel->getAlleLeden();

    require_once '../app/views/ledenoverzicht/index.php';
} catch (Exception $e) {
    require_once '../app/views/ledenoverzicht/fout.php';
}
