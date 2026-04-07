<?php
require_once '../app/models/Account.php';

$accountModel = new Account();

$succesmelding = '';
$foutmelding = '';
$rollen = [];
$wijzigAccount = null;

$rolId = '';
$voornaam = '';
$tussenvoegsel = '';
$achternaam = '';
$email = '';
$wachtwoord = '';
$opmerking = '';

try {
    $rollen = $accountModel->getAlleRollen();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $actie = trim($_POST['actie'] ?? '');

        if ($actie === 'laad_wijzig') {
            // Context menu: open wijzig-modal met huidige accountgegevens
            $accountId = (int)($_POST['account_id'] ?? 0);
            if ($accountId > 0) {
                $wijzigAccount = $accountModel->getAccountById($accountId);
            }

        } elseif ($actie === 'wijzig') {
            // Wijzigformulier ingediend
            $accountId    = (int)($_POST['account_id'] ?? 0);
            $rolId        = trim($_POST['rol_id']       ?? '');
            $voornaam     = trim($_POST['voornaam']     ?? '');
            $tussenvoegsel= trim($_POST['tussenvoegsel']?? '');
            $achternaam   = trim($_POST['achternaam']   ?? '');
            $email        = trim($_POST['email']        ?? '');
            $opmerking    = trim($_POST['opmerking']    ?? '');

            if ($rolId === '' || $voornaam === '' || $achternaam === '' || $email === '') {
                // Unhappy: verplichte velden ontbreken
                $foutmelding = 'Vul alle verplichte velden correct in.';
                $wijzigAccount = [
                    'id' => $accountId, 'rol_id' => $rolId,
                    'voornaam' => $voornaam, 'tussenvoegsel' => $tussenvoegsel,
                    'achternaam' => $achternaam, 'email' => $email, 'opmerking' => $opmerking,
                ];
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $foutmelding = 'Vul een geldig e-mailadres in.';
                $wijzigAccount = [
                    'id' => $accountId, 'rol_id' => $rolId,
                    'voornaam' => $voornaam, 'tussenvoegsel' => $tussenvoegsel,
                    'achternaam' => $achternaam, 'email' => $email, 'opmerking' => $opmerking,
                ];
            } else {
                $gelukt = $accountModel->wijzigAccount(
                    $accountId, (int)$rolId, $voornaam, $tussenvoegsel, $achternaam, $email, $opmerking
                );
                if ($gelukt) {
                    // Happy scenario
                    $succesmelding = 'Het account is succesvol gewijzigd.';
                } else {
                    $foutmelding = 'Het account kon niet worden gewijzigd.';
                }
            }

        } elseif ($actie === 'annuleer') {
            // Unhappy scenario: gebruiker heeft de verwijdering geannuleerd
            $foutmelding = 'Het verwijderen is geannuleerd.';
        } elseif ($actie === 'verwijder') {
            // Happy scenario: gebruiker heeft de verwijdering bevestigd
            $verwijderId = (int)($_POST['verwijder_id'] ?? 0);

            if ($verwijderId > 0) {
                $gelukt = $accountModel->verwijderAccount($verwijderId);

                if ($gelukt) {
                    $succesmelding = 'Het account is succesvol verwijderd.';
                } else {
                    $foutmelding = 'Het account kon niet worden verwijderd.';
                }
            }
        } else {
            $rolId = trim($_POST['rol_id'] ?? '');
            $voornaam = trim($_POST['voornaam'] ?? '');
            $tussenvoegsel = trim($_POST['tussenvoegsel'] ?? '');
            $achternaam = trim($_POST['achternaam'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $wachtwoord = trim($_POST['wachtwoord'] ?? '');
            $opmerking = trim($_POST['opmerking'] ?? '');

            if (
                $rolId === '' ||
                $voornaam === '' ||
                $achternaam === '' ||
                $email === '' ||
                $wachtwoord === ''
            ) {
                $foutmelding = 'Vul alle verplichte velden in.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $foutmelding = 'Vul een geldig e-mailadres in.';
            } elseif ($accountModel->emailBestaatAl($email)) {
                $foutmelding = 'Dit e-mailadres bestaat al.';
            } else {
                $gelukt = $accountModel->voegAccountToe(
                    (int)$rolId,
                    $voornaam,
                    $tussenvoegsel,
                    $achternaam,
                    $email,
                    $wachtwoord,
                    $opmerking
                );

                if ($gelukt) {
                    $succesmelding = 'Het account is succesvol opgeslagen.';
                    $rolId = '';
                    $voornaam = '';
                    $tussenvoegsel = '';
                    $achternaam = '';
                    $email = '';
                    $wachtwoord = '';
                    $opmerking = '';
                } else {
                    $foutmelding = 'Het account kon niet worden opgeslagen.';
                }
            }
        }
    }

    $accounts = $accountModel->getAlleAccounts();

    require_once '../app/views/accountenoverzicht/index.php';
} catch (Exception $e) {
    echo $e->getMessage();
}