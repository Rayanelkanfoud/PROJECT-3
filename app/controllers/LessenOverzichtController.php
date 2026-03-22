<?php
require_once '../app/models/Les.php';

// Model laden om lessen op te halen en nieuwe lessen toe te voegen
$lesModel = new Les();

// Variabelen voor meldingen en formulier
$succesmelding = '';
$foutmelding = '';

// Formuliervelden vooraf leeg maken
$naam = '';
$prijs = '';
$datum = '';
$tijd = '';
$minAantalPersonen = '';
$maxAantalPersonen = '';
$status = '';
$isAanbieding = 0;
$opmerking = '';

try {
    // Controleren of het formulier is verzonden
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $naam = trim($_POST['naam'] ?? '');
        $prijs = trim($_POST['prijs'] ?? '');
        $datum = trim($_POST['datum'] ?? '');
        $tijd = trim($_POST['tijd'] ?? '');
        $minAantalPersonen = trim($_POST['min_aantal_personen'] ?? '');
        $maxAantalPersonen = trim($_POST['max_aantal_personen'] ?? '');
        $status = trim($_POST['status'] ?? '');
        $isAanbieding = isset($_POST['is_aanbieding']) ? 1 : 0;
        $opmerking = trim($_POST['opmerking'] ?? '');

        // Validatie van verplichte velden
        if (
            $naam === '' ||
            $prijs === '' ||
            $datum === '' ||
            $tijd === '' ||
            $minAantalPersonen === '' ||
            $maxAantalPersonen === '' ||
            $status === ''
        ) {
            $foutmelding = 'Vul alle verplichte velden in.';
        } elseif (!is_numeric($prijs) || !is_numeric($minAantalPersonen) || !is_numeric($maxAantalPersonen)) {
            $foutmelding = 'Prijs, minimum en maximum aantal personen moeten geldig zijn.';
        } elseif ((int)$minAantalPersonen > (int)$maxAantalPersonen) {
            $foutmelding = 'Het minimum aantal personen mag niet groter zijn dan het maximum aantal personen.';
        } else {
            // Les toevoegen aan database
            $gelukt = $lesModel->voegLesToe(
                $naam,
                $prijs,
                $datum,
                $tijd,
                (int)$minAantalPersonen,
                (int)$maxAantalPersonen,
                $status,
                $isAanbieding,
                $opmerking
            );

            if ($gelukt) {
                $succesmelding = 'De les is succesvol opgeslagen.';

                // Formulier leegmaken na succesvolle insert
                $naam = '';
                $prijs = '';
                $datum = '';
                $tijd = '';
                $minAantalPersonen = '';
                $maxAantalPersonen = '';
                $status = '';
                $isAanbieding = 0;
                $opmerking = '';
            } else {
                $foutmelding = 'De les kon niet worden opgeslagen.';
            }
        }
    }

    // Altijd opnieuw alle lessen ophalen voor het overzicht
    $lessen = $lesModel->getAlleLessen();

    // Pagina tonen
    require_once '../app/views/lessenoverzicht/index.php';
} catch (Exception $e) {
    require_once '../app/views/lessenoverzicht/fout.php';
}