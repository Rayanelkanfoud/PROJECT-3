<?php
// Model laden om leden uit de database op te halen
require_once '../app/models/Lid.php';

// Hiermee kun je tijdelijk het unhappy scenario testen
$testUnhappy = false;

try {
    if ($testUnhappy) {
        $leden = [];
    } else {
        // Model aanmaken en alle leden ophalen
        $lidModel = new Lid();
        $leden = $lidModel->getAlleLeden();
    }

    // Als er leden zijn gevonden, toon het overzicht
    if (!empty($leden)) {
        require_once '../app/views/ledenoverzicht/index.php';
    } else {
        // Unhappy flow: geen leden gevonden
        require_once '../app/views/ledenoverzicht/fout.php';
    }
} catch (Exception $e) {
    // Als er een fout optreedt, toon de foutpagina
    require_once '../app/views/ledenoverzicht/fout.php';
}