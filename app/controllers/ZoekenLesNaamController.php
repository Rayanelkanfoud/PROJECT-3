<?php
require_once '../app/models/Les.php';

$zoekterm = '';
$resultaten = [];
$foutmelding = '';
$heeftGezocht = false;

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $heeftGezocht = true;
        $zoekterm = trim($_POST['zoekterm'] ?? '');

        if ($zoekterm === '') {
            $foutmelding = 'Vul een lesnaam in.';
        } else {
            $lesModel = new Les();
            $resultaten = $lesModel->zoekOpNaam($zoekterm);

            if (empty($resultaten)) {
                $foutmelding = 'Les niet gevonden.';
            }
        }
    }

    require_once '../app/views/zoekenlesnaam/index.php';
} catch (Exception $e) {
    require_once '../app/views/zoekenlesnaam/fout.php';
}