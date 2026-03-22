<?php
require_once __DIR__ . '/../app/config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
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
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/inloggen.css">
</head>
<body>

<header class="site-header">
    <div class="container site-header__inner">
        <a class="site-logo" href="<?php echo URLROOT; ?>">FitForFun</a>

        <nav class="site-nav">
            <a href="<?php echo URLROOT; ?>">Home</a>
            <a href="<?php echo URLROOT; ?>/aanbiedingen.php">Aanbiedingen</a>
            <a href="<?php echo URLROOT; ?>/lessen.php">Lessen</a>
            
            <!-- <a href="<?php echo URLROOT; ?>/zoeken.php">Zoeken les</a> -->

            <a href="<?php echo URLROOT; ?>/accounts.php">Accounts</a>
            <a href="<?php echo URLROOT; ?>/medewerkers.php">Medewerkers</a>
            <a href="<?php echo URLROOT; ?>/leden.php">Leden</a>
            
            <!-- <a href="<?php echo URLROOT; ?>/lidzoeken.php">Zoeken lid</a> -->

            <a href="<?php echo URLROOT; ?>/reserveringen.php">Reserveringen</a>
            <a href="<?php echo URLROOT; ?>/geplandelessen.php">Planning</a>

<?php if (isset($_SESSION['gebruiker_id'])): ?>
    <a href="<?php echo URLROOT; ?>/uitloggen.php">Uitloggen</a>
    <a href="<?php echo URLROOT; ?>/uitloggen.php?test=fout">Uitloggen fout</a>
<?php else: ?>
    <a href="<?php echo URLROOT; ?>/inloggen.php">Inloggen</a>
<?php endif; ?>
        </nav>
    </div>
</header>