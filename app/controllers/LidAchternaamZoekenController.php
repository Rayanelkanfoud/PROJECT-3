<?php
require_once '../app/models/Lid.php';

$zoekterm = '';
$resultaten = [];
$foutmelding = '';
$heeftGezocht = false;

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $heeftGezocht = true;
        $zoekterm = trim($_POST['zoekterm'] ?? '');

        if ($zoekterm === '') {
            $foutmelding = 'Vul een achternaam in.';
        } else {
            $lidModel = new Lid();
            $resultaten = $lidModel->zoekOpAchternaam($zoekterm);

            if (empty($resultaten)) {
                $foutmelding = 'Lid niet gevonden.';
            }
        }
    }

    require_once '../app/views/lidachternaamzoeken/index.php';
} catch (Exception $e) {
    require_once '../app/views/lidachternaamzoeken/fout.php';
}