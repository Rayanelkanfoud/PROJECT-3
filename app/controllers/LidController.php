<?php
class LidController extends BaseController
{
    // READ — overzicht + zoeken
    public function index()
    {
        $lidModel = $this->model('Lid');
        $zoek = trim($_GET['zoek'] ?? '');

        $leden = ($zoek !== '') ? $lidModel->zoekOpAchternaam($zoek) : $lidModel->getAll();

        $this->view('lid/index', ['leden' => $leden, 'zoek' => $zoek]);
    }

    // CREATE — formulier tonen
    public function create()
    {
        $data = ['fouten' => [], 'voornaam' => '', 'achternaam' => '', 'email' => '',
                 'telefoon' => '', 'lidsinds' => date('Y-m-d'), 'status' => 'actief'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_merge($data, [
                'voornaam'   => trim($_POST['voornaam']   ?? ''),
                'achternaam' => trim($_POST['achternaam'] ?? ''),
                'email'      => trim($_POST['email']      ?? ''),
                'telefoon'   => trim($_POST['telefoon']   ?? ''),
                'lidsinds'   => $_POST['lidsinds']        ?? date('Y-m-d'),
                'status'     => $_POST['status']          ?? 'actief',
            ]);

            // Validatie
            if (empty($data['voornaam']))   $data['fouten'][] = 'Voornaam is verplicht.';
            if (empty($data['achternaam'])) $data['fouten'][] = 'Achternaam is verplicht.';
            if (empty($data['email']))      $data['fouten'][] = 'E-mail is verplicht.';
            elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $data['fouten'][] = 'Ongeldig e-mailadres.';

            if (empty($data['fouten'])) {
                $lidModel = $this->model('Lid');
                if ($lidModel->emailBestaat($data['email'])) {
                    $data['fouten'][] = 'Dit e-mailadres is al in gebruik.';
                } else {
                    $lidModel->create($data);
                    header('Location: ' . URLROOT . '/lid/index?melding=toegevoegd');
                    exit;
                }
            }
        }

        $this->view('lid/create', $data);
    }

    // UPDATE — formulier tonen + opslaan
    public function edit($id = null)
    {
        if (!$id) { header('Location: ' . URLROOT . '/lid/index'); exit; }

        $lidModel = $this->model('Lid');
        $lid = $lidModel->getById($id);
        if (!$lid) { header('Location: ' . URLROOT . '/lid/index'); exit; }

        $data = [
            'fouten'     => [],
            'id'         => $id,
            'voornaam'   => $lid->Voornaam,
            'achternaam' => $lid->Achternaam,
            'email'      => $lid->Email,
            'telefoon'   => $lid->Telefoon ?? '',
            'lidsinds'   => $lid->LidSinds,
            'status'     => $lid->Status,
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_merge($data, [
                'voornaam'   => trim($_POST['voornaam']   ?? ''),
                'achternaam' => trim($_POST['achternaam'] ?? ''),
                'email'      => trim($_POST['email']      ?? ''),
                'telefoon'   => trim($_POST['telefoon']   ?? ''),
                'lidsinds'   => $_POST['lidsinds']        ?? $lid->LidSinds,
                'status'     => $_POST['status']          ?? 'actief',
            ]);

            if (empty($data['voornaam']))   $data['fouten'][] = 'Voornaam is verplicht.';
            if (empty($data['achternaam'])) $data['fouten'][] = 'Achternaam is verplicht.';
            if (empty($data['email']))      $data['fouten'][] = 'E-mail is verplicht.';
            elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $data['fouten'][] = 'Ongeldig e-mailadres.';

            if (empty($data['fouten'])) {
                if ($lidModel->emailBestaat($data['email'], $id)) {
                    $data['fouten'][] = 'Dit e-mailadres is al in gebruik door een ander lid.';
                } else {
                    $lidModel->update($id, $data);
                    header('Location: ' . URLROOT . '/lid/index?melding=bijgewerkt');
                    exit;
                }
            }
        }

        $this->view('lid/edit', $data);
    }

    // DELETE
    public function delete($id = null)
    {
        if (!$id) { header('Location: ' . URLROOT . '/lid/index'); exit; }
        $lidModel = $this->model('Lid');
        $lidModel->delete($id);
        header('Location: ' . URLROOT . '/lid/index?melding=verwijderd');
        exit;
    }
}
