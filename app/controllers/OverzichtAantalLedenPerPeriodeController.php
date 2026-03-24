<?php
require_once '../app/models/LedenPerPeriode.php';

$model = new LedenPerPeriode();

$periode = '';
$totaalLeden = null;
$foutmelding = '';
$beschikbarePeriodes = [];

try {
    $beschikbarePeriodes = $model->getBeschikbarePeriodes();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $periode = trim($_POST['periode'] ?? '');

        if ($periode === '') {
            $foutmelding = 'Kies een periode.';
        } else {
            $resultaat = $model->getAantalLedenPerPeriode($periode);
            $totaalLeden = (int) ($resultaat['totaal'] ?? 0);

            if ($totaalLeden === 0) {
                $foutmelding = 'Er zijn geen ledengegevens beschikbaar voor deze periode.';
            }
        }
    }

    require_once '../app/views/overzichtaantalleden/index.php';
} catch (Exception $e) {
    require_once '../app/views/overzichtaantalleden/fout.php';
}