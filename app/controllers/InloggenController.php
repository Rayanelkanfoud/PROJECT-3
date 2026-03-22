<?php
require_once '../app/models/Gebruiker.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$email = '';
$foutmelding = '';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email'] ?? '');
        $wachtwoord = trim($_POST['wachtwoord'] ?? '');

        if ($email === '' || $wachtwoord === '') {
            $foutmelding = 'Vul je e-mailadres en wachtwoord in.';
        } else {
            $gebruikerModel = new Gebruiker();
            $gebruiker = $gebruikerModel->login($email, $wachtwoord);

            if ($gebruiker) {
                $_SESSION['gebruiker_id'] = $gebruiker['id'];
                $_SESSION['rol_id'] = $gebruiker['rol_id'];
                $_SESSION['naam'] = trim(
                    $gebruiker['voornaam'] . ' ' .
                    ($gebruiker['tussenvoegsel'] ? $gebruiker['tussenvoegsel'] . ' ' : '') .
                    $gebruiker['achternaam']
                );
                $_SESSION['email'] = $gebruiker['email'];

                $gebruikerModel->zetOpIngelogd($gebruiker['id']);

                header('Location: ' . URLROOT);
                exit;
            } else {
                $foutmelding = 'De inloggegevens zijn onjuist.';
            }
        }
    }

    require_once '../app/views/inloggen/index.php';
} catch (Exception $e) {
    require_once '../app/views/inloggen/fout.php';
}