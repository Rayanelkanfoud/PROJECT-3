<?php
require_once '../app/models/Reservering.php';

$testUnhappy = false;

try {
    if ($testUnhappy) {
        $reserveringen = [];
    } else {
        $reserveringModel = new Reservering();
        $reserveringen = $reserveringModel->getAlleReserveringen();
    }

    if (!empty($reserveringen)) {
        require_once '../app/views/reserveringoverzicht/index.php';
    } else {
        require_once '../app/views/reserveringoverzicht/fout.php';
    }
} catch (Exception $e) {
    require_once '../app/views/reserveringoverzicht/fout.php';
}