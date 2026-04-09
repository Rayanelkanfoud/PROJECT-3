<?php
require_once '../app/models/Reservering.php';

$succesmelding    = '';
$foutmelding      = '';
$lidId            = '';
$lesId            = '';
$wijzigReservering = null;
$periodeResultaten = null;
$vanDatum         = '';
$totDatum         = '';

try {
    $reserveringModel = new Reservering();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $actie = trim($_POST['actie'] ?? '');

        if ($actie === 'laad_wijzig') {
            // Context menu: open wijzig-modal
            $reserveringId = (int)($_POST['reservering_id'] ?? 0);
            if ($reserveringId > 0) {
                $wijzigReservering = $reserveringModel->getReserveringById($reserveringId);
            }

        } elseif ($actie === 'wijzig') {
            // Wijzigformulier ingediend
            $reserveringId = (int)($_POST['reservering_id'] ?? 0);
            $lidId         = trim($_POST['lid_id']          ?? '');
            $lesId         = trim($_POST['les_id']          ?? '');
            $statusWijzig  = trim($_POST['reserveringsstatus'] ?? '');

            if ($lidId === '' || $lesId === '' || $statusWijzig === '') {
                // Unhappy scenario
                $foutmelding = 'Vul alle verplichte velden in.';
                $wijzigReservering = [
                    'id' => $reserveringId,
                    'lid_id' => $lidId,
                    'les_id' => $lesId,
                    'reserveringsstatus' => $statusWijzig,
                ];
            } else {
                $gelukt = $reserveringModel->wijzigReservering($reserveringId, (int)$lidId, (int)$lesId, $statusWijzig);
                if ($gelukt) {
                    // Happy scenario
                    $succesmelding = 'De reservering is succesvol gewijzigd.';
                } else {
                    $foutmelding = 'De reservering kon niet worden gewijzigd.';
                }
            }

        } elseif ($actie === 'verwijder') {
            // Happy scenario: reservering verwijderen bevestigd
            $reserveringId = (int)($_POST['verwijder_id'] ?? 0);
            if ($reserveringId > 0) {
                $gelukt = $reserveringModel->verwijderReservering($reserveringId);
                if ($gelukt) {
                    $succesmelding = 'De reservering is succesvol verwijderd.';
                } else {
                    $foutmelding = 'De reservering kon niet worden verwijderd.';
                }
            }

        } elseif ($actie === 'annuleer_verwijder') {
            // Unhappy scenario: verwijdering geannuleerd
            $foutmelding = 'Het verwijderen is geannuleerd.';

        } elseif ($actie === 'periode_zoeken') {
            // Overzicht reserveringen per periode (US 331)
            $vanDatum = trim($_POST['van_datum'] ?? '');
            $totDatum = trim($_POST['tot_datum'] ?? '');
            if ($vanDatum !== '' && $totDatum !== '') {
                $periodeResultaten = $reserveringModel->getAantalPerPeriode($vanDatum, $totDatum);
            }

        } else {
            // Nieuwe reservering toevoegen
            $lidId = trim($_POST['lid_id'] ?? '');
            $lesId = trim($_POST['les_id'] ?? '');

            if ($lidId === '' || $lesId === '') {
                $foutmelding = 'Selecteer een lid en een les.';
            } elseif ($reserveringModel->reserveringBestaat((int)$lidId, (int)$lesId)) {
                $foutmelding = 'Dit lid heeft al een reservering voor deze les.';
            } else {
                $gelukt = $reserveringModel->voegReserveringToe((int)$lidId, (int)$lesId);
                if ($gelukt) {
                    $succesmelding = 'De reservering is succesvol opgeslagen.';
                    $lidId = '';
                    $lesId = '';
                } else {
                    $foutmelding = 'De reservering kon niet worden opgeslagen. Probeer het opnieuw.';
                }
            }
        }
    }

    $reserveringen = $reserveringModel->getAlleReserveringen();
    $leden         = $reserveringModel->getAlleLeden();
    $lessen        = $reserveringModel->getAlleLessen();

    require_once '../app/views/reserveringoverzicht/index.php';
} catch (Exception $e) {
    require_once '../app/views/reserveringoverzicht/fout.php';
}
