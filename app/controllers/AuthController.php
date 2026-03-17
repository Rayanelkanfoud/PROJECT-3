<?php

class AuthController extends BaseController
{
    private $authModel;

    public function __construct()
    {
        $this->authModel = $this->model('AuthModel');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $data = [
                'title' => 'Inloggen',
                'email' => $email,
                'password' => $password,
                'emailError' => '',
                'passwordError' => '',
                'loginError' => ''
            ];

            if (empty($email)) {
                $data['emailError'] = 'Vul een e-mailadres in';
            }

            if (empty($password)) {
                $data['passwordError'] = 'Vul een wachtwoord in';
            }

            if (empty($data['emailError']) && empty($data['passwordError'])) {
                $user = $this->authModel->getUserByEmail($email);

                if ($user) {
                    if (password_verify($password, $user->Wachtwoord)) {

                        $_SESSION['user_id'] = $user->Id;
                        $_SESSION['user_name'] = $user->Naam;
                        $_SESSION['user_email'] = $user->Email;

                        header('Location: ' . URLROOT . '/dashboard/index');
                        exit;
                    } else {
                        $data['loginError'] = 'De inloggegevens zijn onjuist';
                    }
                } else {
                    $data['loginError'] = 'De inloggegevens zijn onjuist';
                }
            }

            $this->view('auth/login', $data);

        } else {
            $data = [
                'title' => 'Inloggen',
                'email' => '',
                'password' => '',
                'emailError' => '',
                'passwordError' => '',
                'loginError' => ''
            ];

            $this->view('auth/login', $data);
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {

            unset($_SESSION['user_id']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_email']);

            session_regenerate_id(true);

            if (!isset($_SESSION['user_id'])) {
                header('Location: ' . URLROOT . '/home/index');
                exit;
            } else {
                $_SESSION['logout_error'] = 'Uitloggen is niet gelukt';
                header('Location: ' . URLROOT . '/dashboard/index');
                exit;
            }

        } else {
            $_SESSION['logout_error'] = 'Je bent niet ingelogd';
            header('Location: ' . URLROOT . '/auth/login');
            exit;
        }
    }
}