<?php
require_once '../app/models/GeplandeLes.php';

$testUnhappy = false;

try {
    if ($testUnhappy) {
        $geplandeLessen = [];
    } else {
        $geplandeLesModel = new GeplandeLes();
        $geplandeLessen = $geplandeLesModel->getAlleGeplandeLessen();
    }

    if (!empty($geplandeLessen)) {
        require_once '../app/views/geplandelessenoverzicht/index.php';
    } else {
        require_once '../app/views/geplandelessenoverzicht/fout.php';
    }
} catch (Exception $e) {
    require_once '../app/views/geplandelessenoverzicht/fout.php';
}