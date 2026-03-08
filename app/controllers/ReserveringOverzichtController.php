<?php
// Model laden om reserveringen uit de database op te halen
require_once '../app/models/Reservering.php';

// Hiermee kun je tijdelijk het unhappy scenario testen
$testUnhappy = false;

try {
    if ($testUnhappy) {
        // Lege array gebruiken om foutscenario te testen
        $reserveringen = [];
    } else {
        // Model aanmaken en alle reserveringen ophalen
        $reserveringModel = new Reservering();
        $reserveringen = $reserveringModel->getAlleReserveringen();
    }

    // Als er reserveringen zijn gevonden, toon het overzicht
    if (!empty($reserveringen)) {
        require_once '../app/views/reserveringoverzicht/index.php';
    } else {
        // Unhappy flow: geen reserveringen gevonden
        require_once '../app/views/reserveringoverzicht/fout.php';
    }
} catch (Exception $e) {
    // Als er een fout optreedt, toon de foutpagina
    require_once '../app/views/reserveringoverzicht/fout.php';
}