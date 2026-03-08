<?php
require_once '../app/models/Medewerker.php';

$testUnhappy = false;

try {
    if ($testUnhappy) {
        $medewerkers = [];
    } else {
        $medewerkerModel = new Medewerker();
        $medewerkers = $medewerkerModel->getAlleMedewerkers();
    }

    if (!empty($medewerkers)) {
        require_once '../app/views/medewerkeroverzicht/index.php';
    } else {
        require_once '../app/views/medewerkeroverzicht/fout.php';
    }
} catch (Exception $e) {
    require_once '../app/views/medewerkeroverzicht/fout.php';
}