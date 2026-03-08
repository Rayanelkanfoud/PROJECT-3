<?php
// Model laden om medewerkers uit de database op te halen
require_once '../app/models/Medewerker.php';

// Hiermee kun je tijdelijk het unhappy scenario testen
$testUnhappy = false;

try {
    if ($testUnhappy) {
        // Lege array gebruiken om foutscenario te testen
        $medewerkers = [];
    } else {
        // Model aanmaken en alle medewerkers ophalen
        $medewerkerModel = new Medewerker();
        $medewerkers = $medewerkerModel->getAlleMedewerkers();
    }

    // Als er medewerkers zijn gevonden, toon het overzicht
    if (!empty($medewerkers)) {
        require_once '../app/views/medewerkeroverzicht/index.php';
    } else {
        // Unhappy flow: geen medewerkers gevonden
        require_once '../app/views/medewerkeroverzicht/fout.php';
    }
} catch (Exception $e) {
    // Als er een fout optreedt, toon de foutpagina
    require_once '../app/views/medewerkeroverzicht/fout.php';
}