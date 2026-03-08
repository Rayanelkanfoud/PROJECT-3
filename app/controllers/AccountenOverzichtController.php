<?php
// Model laden om accounts uit de database op te halen
require_once '../app/models/Account.php';

// Hiermee kun je tijdelijk het unhappy scenario testen
$testUnhappy = false;

try {
    if ($testUnhappy) {
        // Lege array gebruiken om foutscenario te testen
        $accounts = [];
    } else {
        // Model aanmaken en alle accounts ophalen
        $accountModel = new Account();
        $accounts = $accountModel->getAlleAccounts();
    }

    // Als er accounts zijn gevonden, toon het overzicht
    if (!empty($accounts)) {
        require_once '../app/views/accountenoverzicht/index.php';
    } else {
        // Unhappy flow: geen accounts gevonden
        require_once '../app/views/accountenoverzicht/fout.php';
    }
} catch (Exception $e) {
    // Als er een fout optreedt, toon de foutpagina
    require_once '../app/views/accountenoverzicht/fout.php';
}