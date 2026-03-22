<?php

class DashboardController extends BaseController
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/auth/login');
            exit;
        }

        $data = [
            'title' => 'Dashboard'
        ];

        $this->view('dashboard/index', $data);
    }
}