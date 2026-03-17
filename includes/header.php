<?php require_once __DIR__ . '/../app/config/config.php'; ?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAAM; ?></title>

    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/site.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/home.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/aanbiedingen.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/lessen.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/zoeken.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/accounts.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/medewerkers.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/leden.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/lidzoeken.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/reserveringen.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/geplandelessen.css">
</head>
<body>

<header class="site-header">
    <div class="container site-header__inner">
        <a class="site-logo" href="<?php echo URLROOT; ?>">FitForFun</a>

        <nav class="site-nav">
            <a href="<?php echo URLROOT; ?>/aanbiedingen.php">Aanbiedingen</a>
            <a href="<?php echo URLROOT; ?>/lessen.php">Lessen</a>
            <a href="<?php echo URLROOT; ?>/accounts.php">Accounts</a>
            <a href="<?php echo URLROOT; ?>/medewerkers.php">Medewerkers</a>
            <a href="<?php echo URLROOT; ?>/leden.php">Leden</a>
            <a href="<?php echo URLROOT; ?>/reserveringen.php">Reserveringen</a>
            <a href="<?php echo URLROOT; ?>/geplandelessen.php">Planning</a>
        </nav>
    </div>
</header>