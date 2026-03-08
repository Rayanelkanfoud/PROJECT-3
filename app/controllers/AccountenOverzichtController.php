<?php
require_once '../app/models/Account.php';

$testUnhappy = false;

try {
    if ($testUnhappy) {
        $accounts = [];
    } else {
        $accountModel = new Account();
        $accounts = $accountModel->getAlleAccounts();
    }

    if (!empty($accounts)) {
        require_once '../app/views/accountenoverzicht/index.php';
    } else {
        require_once '../app/views/accountenoverzicht/fout.php';
    }
} catch (Exception $e) {
    require_once '../app/views/accountenoverzicht/fout.php';
}