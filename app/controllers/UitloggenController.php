<?php
require_once '../app/models/Gebruiker.php';
require_once '../app/config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    if (!isset($_SESSION['gebruiker_id'])) {
        header('Location: ' . URLROOT . '/inloggen.php');
        exit;
    }

    if (isset($_GET['test']) && $_GET['test'] === 'fout') {
        throw new Exception('Testfout bij uitloggen');
    }

    $gebruikerModel = new Gebruiker();
    $gelukt = $gebruikerModel->zetOpUitgelogd($_SESSION['gebruiker_id']);

    if (!$gelukt) {
        throw new Exception('Uitloggen mislukt');
    }

    $_SESSION = [];
    session_destroy();

    header('Location: ' . URLROOT . '/inloggen.php?succes=uitgelogd');
    exit;
} catch (Exception $e) {
    header('Location: ' . URLROOT . '/inloggen.php?fout=uitloggen');
    exit;
}