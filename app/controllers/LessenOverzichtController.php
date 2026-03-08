<?php
require_once '../app/models/Les.php';

$testOnhappy = false;

try {
    if ($testOnhappy) {
        $lessen = [];
    } else {
        $lesModel = new Les();
        $lessen = $lesModel->getAlleLessen();
    }

    if (!empty($lessen)) {
        require_once '../app/views/lessenoverzicht/index.php';
    } else {
        require_once '../app/views/lessenoverzicht/fout.php';
    }
} catch (Exception $e) {
    require_once '../app/views/lessenoverzicht/fout.php';
}