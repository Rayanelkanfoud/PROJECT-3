<?php
// Model laden om lessen uit de database op te halen
require_once '../app/models/Les.php';

// Hiermee kun je tijdelijk het unhappy scenario testen
$testUnhappy = false;

try {
    if ($testUnhappy) {
        // Lege array gebruiken om foutscenario te testen
        $lessen = [];
    } else {
        // Model aanmaken en alle lessen ophalen
        $lesModel = new Les();
        $lessen = $lesModel->getAlleLessen();
    }

    // Als er lessen zijn gevonden, toon het overzicht
    if (!empty($lessen)) {
        require_once '../app/views/lessenoverzicht/index.php';
    } else {
        // Unhappy flow: geen lessen gevonden
        require_once '../app/views/lessenoverzicht/fout.php';
    }
} catch (Exception $e) {
    // Als er een fout optreedt, toon de foutpagina
    require_once '../app/views/lessenoverzicht/fout.php';
}