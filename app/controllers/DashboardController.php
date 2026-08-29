<?php

require_once __DIR__ . '/../models/DashboardModel.php';

class DashboardController
{
    public function index(): void
    {
        session_start();

        if (!isset($_SESSION['correo'])) {
            header('Location: ../public/login.php');
            exit();
        }

        $model = new DashboardModel();
        $totals = $model->totals();

        require __DIR__ . '/../views/dashboard/index.php';
    }
}
