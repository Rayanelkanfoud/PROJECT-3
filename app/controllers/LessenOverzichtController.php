<?php
require_once '../app/models/Les.php';

$lesModel = new Les();

$succesmelding    = '';
$foutmelding      = '';
$wijzigLes        = null;
$zoekDatum        = '';
$zoekResultaten   = null;

$naam             = '';
$prijs            = '';
$datum            = '';
$tijd             = '';
$minAantalPersonen = '';
$maxAantalPersonen = '';
$status           = '';
$isAanbieding     = 0;
$opmerking        = '';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $actie = trim($_POST['actie'] ?? '');

        if ($actie === 'laad_wijzig') {
            // Context menu: open wijzig-modal met huidige lesgegevens
            $lesId = (int)($_POST['les_id'] ?? 0);
            if ($lesId > 0) {
                $wijzigLes = $lesModel->getLesById($lesId);
            }

        } elseif ($actie === 'wijzig') {
            // Wijzigformulier ingediend
            $lesId             = (int)($_POST['les_id']              ?? 0);
            $naam              = trim($_POST['naam']                  ?? '');
            $prijs             = trim($_POST['prijs']                 ?? '');
            $datum             = trim($_POST['datum']                 ?? '');
            $tijd              = trim($_POST['tijd']                  ?? '');
            $minAantalPersonen = trim($_POST['min_aantal_personen']   ?? '');
            $maxAantalPersonen = trim($_POST['max_aantal_personen']   ?? '');
            $status            = trim($_POST['status']                ?? '');
            $isAanbieding      = isset($_POST['is_aanbieding']) ? 1 : 0;
            $opmerking         = trim($_POST['opmerking']             ?? '');

            if ($naam === '' || $prijs === '' || $datum === '' || $tijd === '' || $minAantalPersonen === '' || $maxAantalPersonen === '' || $status === '') {
                // Unhappy scenario: verplichte velden ontbreken
                $foutmelding = 'Vul alle verplichte velden correct in.';
                $wijzigLes = [
                    'id' => $lesId, 'naam' => $naam, 'prijs' => $prijs,
                    'datum' => $datum, 'tijd' => $tijd,
                    'min_aantal_personen' => $minAantalPersonen,
                    'max_aantal_personen' => $maxAantalPersonen,
                    'status' => $status, 'is_aanbieding' => $isAanbieding, 'opmerking' => $opmerking,
                ];
            } elseif (!is_numeric($prijs) || !is_numeric($minAantalPersonen) || !is_numeric($maxAantalPersonen)) {
                $foutmelding = 'Vul alle verplichte velden correct in.';
                $wijzigLes = [
                    'id' => $lesId, 'naam' => $naam, 'prijs' => $prijs,
                    'datum' => $datum, 'tijd' => $tijd,
                    'min_aantal_personen' => $minAantalPersonen,
                    'max_aantal_personen' => $maxAantalPersonen,
                    'status' => $status, 'is_aanbieding' => $isAanbieding, 'opmerking' => $opmerking,
                ];
            } else {
                $gelukt = $lesModel->wijzigLes(
                    $lesId, $naam, $prijs, $datum, $tijd,
                    (int)$minAantalPersonen, (int)$maxAantalPersonen,
                    $status, $isAanbieding, $opmerking
                );
                if ($gelukt) {
                    // Happy scenario
                    $succesmelding = 'De les is succesvol gewijzigd.';
                } else {
                    $foutmelding = 'De les kon niet worden gewijzigd.';
                }
            }

        } elseif ($actie === 'annuleer_les') {
            // Happy scenario: les annuleren bevestigd
            $lesId = (int)($_POST['les_id'] ?? 0);
            if ($lesId > 0) {
                $gelukt = $lesModel->annuleerLes($lesId);
                if ($gelukt) {
                    $succesmelding = 'De les is succesvol geannuleerd.';
                } else {
                    $foutmelding = 'De les kon niet worden geannuleerd.';
                }
            }

        } elseif ($actie === 'annuleer_annuleren') {
            // Unhappy scenario: annulering geannuleerd
            $foutmelding = 'Het annuleren is geannuleerd.';

        } else {
            // Nieuwe les toevoegen
            $naam              = trim($_POST['naam']                  ?? '');
            $prijs             = trim($_POST['prijs']                 ?? '');
            $datum             = trim($_POST['datum']                 ?? '');
            $tijd              = trim($_POST['tijd']                  ?? '');
            $minAantalPersonen = trim($_POST['min_aantal_personen']   ?? '');
            $maxAantalPersonen = trim($_POST['max_aantal_personen']   ?? '');
            $status            = trim($_POST['status']                ?? '');
            $isAanbieding      = isset($_POST['is_aanbieding']) ? 1 : 0;
            $opmerking         = trim($_POST['opmerking']             ?? '');

            if ($naam === '' || $prijs === '' || $datum === '' || $tijd === '' || $minAantalPersonen === '' || $maxAantalPersonen === '' || $status === '') {
                $foutmelding = 'Vul alle verplichte velden in.';
            } elseif (!is_numeric($prijs) || !is_numeric($minAantalPersonen) || !is_numeric($maxAantalPersonen)) {
                $foutmelding = 'Prijs, minimum en maximum aantal personen moeten geldig zijn.';
            } elseif ((int)$minAantalPersonen > (int)$maxAantalPersonen) {
                $foutmelding = 'Het minimum aantal personen mag niet groter zijn dan het maximum aantal personen.';
            } else {
                $gelukt = $lesModel->voegLesToe($naam, $prijs, $datum, $tijd, (int)$minAantalPersonen, (int)$maxAantalPersonen, $status, $isAanbieding, $opmerking);
                if ($gelukt) {
                    $succesmelding = 'De les is succesvol opgeslagen.';
                    $naam = $prijs = $datum = $tijd = $minAantalPersonen = $maxAantalPersonen = $status = $opmerking = '';
                    $isAanbieding = 0;
                } else {
                    $foutmelding = 'De les kon niet worden opgeslagen.';
                }
            }
        }

    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['zoek_datum'])) {
        // Zoeken op datum (US 84)
        $zoekDatum = trim($_GET['zoek_datum']);
        if ($zoekDatum !== '') {
            $zoekResultaten = $lesModel->zoekOpDatum($zoekDatum);
        }
    }

    $lessen = $lesModel->getAlleLessen();

    require_once '../app/views/lessenoverzicht/index.php';
} catch (Exception $e) {
    require_once '../app/views/lessenoverzicht/fout.php';
}
