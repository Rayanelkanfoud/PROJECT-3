<?php
// Model laden om geplande lessen uit de database op te halen
require_once '../app/models/GeplandeLes.php';

// Hiermee kun je tijdelijk het unhappy scenario testen
$testUnhappy = false;

try {
    if ($testUnhappy) {
        // Lege array gebruiken om foutscenario te testen
        $geplandeLessen = [];
    } else {
        // Model aanmaken en alle geplande lessen ophalen
        $geplandeLesModel = new GeplandeLes();
        $geplandeLessen = $geplandeLesModel->getAlleGeplandeLessen();
    }

    // Als er geplande lessen zijn gevonden, toon het overzicht
    if (!empty($geplandeLessen)) {
        require_once '../app/views/geplandelessenoverzicht/index.php';
    } else {
        // Unhappy flow: geen geplande lessen gevonden
        require_once '../app/views/geplandelessenoverzicht/fout.php';
    }
} catch (Exception $e) {
    // Als er een fout optreedt, toon de foutpagina
    require_once '../app/views/geplandelessenoverzicht/fout.php';
}