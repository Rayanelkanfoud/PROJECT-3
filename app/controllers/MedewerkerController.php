<?php
class MedewerkerController extends BaseController
{
    // READ — overzicht
    public function index()
    {
        $medewerkerModel = $this->model('Medewerker');
        $this->view('medewerker/index', ['medewerkers' => $medewerkerModel->getAll()]);
    }

    // CREATE — formulier tonen + opslaan
    public function create()
    {
        $data = ['fouten' => [], 'naam' => '', 'email' => '', 'wachtwoord' => '', 'status' => 'actief'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_merge($data, [
                'naam'       => trim($_POST['naam']       ?? ''),
                'email'      => trim($_POST['email']      ?? ''),
                'wachtwoord' => $_POST['wachtwoord']      ?? '',
                'status'     => $_POST['status']          ?? 'actief',
            ]);

            // Validatie
            if (empty($data['naam']))       $data['fouten'][] = 'Naam is verplicht.';
            if (empty($data['email']))      $data['fouten'][] = 'E-mail is verplicht.';
            elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $data['fouten'][] = 'Ongeldig e-mailadres.';
            if (empty($data['wachtwoord'])) $data['fouten'][] = 'Wachtwoord is verplicht.';
            elseif (strlen($data['wachtwoord']) < 8) $data['fouten'][] = 'Wachtwoord moet minimaal 8 tekens bevatten.';

            if (empty($data['fouten'])) {
                $medewerkerModel = $this->model('Medewerker');
                if ($medewerkerModel->emailBestaat($data['email'])) {
                    $data['fouten'][] = 'Dit e-mailadres is al in gebruik.';
                } else {
                    $data['wachtwoord'] = password_hash($data['wachtwoord'], PASSWORD_DEFAULT);
                    $medewerkerModel->create($data);
                    header('Location: ' . URLROOT . '/medewerker/index?melding=toegevoegd');
                    exit;
                }
            }
        }

        $this->view('medewerker/create', $data);
    }
}
