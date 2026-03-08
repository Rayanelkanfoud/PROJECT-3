<?php
// Model laden om lessen te kunnen zoeken
require_once '../app/models/Les.php';

// Variabelen voorbereiden voor het zoekformulier en de resultaten
$zoekterm = '';
$resultaten = [];
$foutmelding = '';
$heeftGezocht = false;

try {
    // Controleren of het formulier is verzonden
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $heeftGezocht = true;

        // Zoekterm ophalen en spaties weghalen aan begin en einde
        $zoekterm = trim($_POST['zoekterm'] ?? '');

        // Controleren of het invoerveld niet leeg is
        if ($zoekterm === '') {
            $foutmelding = 'Vul een lesnaam in.';
        } else {
            // Model aanmaken en zoeken op lesnaam
            $lesModel = new Les();
            $resultaten = $lesModel->zoekOpNaam($zoekterm);

            // Als er geen resultaten zijn, foutmelding tonen
            if (empty($resultaten)) {
                $foutmelding = 'Les niet gevonden.';
            }
        }
    }

    // Pagina met formulier en eventuele resultaten tonen
    require_once '../app/views/zoekenlesnaam/index.php';
} catch (Exception $e) {
    // Als er een fout optreedt, toon de foutpagina
    require_once '../app/views/zoekenlesnaam/fout.php';
}