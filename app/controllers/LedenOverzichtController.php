<?php
require_once '../app/models/Lid.php';

$testUnhappy = false;

try {
    if ($testUnhappy) {
        $leden = [];
    } else {
        $lidModel = new Lid();
        $leden = $lidModel->getAlleLeden();
    }

    if (!empty($leden)) {
        require_once '../app/views/ledenoverzicht/index.php';
    } else {
        require_once '../app/views/ledenoverzicht/fout.php';
    }
} catch (Exception $e) {
    require_once '../app/views/ledenoverzicht/fout.php';
}