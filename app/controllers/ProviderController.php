<?php

require_once __DIR__ . '/../models/ProviderModel.php';

class ProviderController
{
    public function index(): void
    {
        session_start();

        if (!isset($_SESSION['correo'])) {
            header('Location: ../public/login.php');
            exit();
        }

        $model = new ProviderModel();
        $providers = $model->getAllProviders();

        require __DIR__ . '/../views/providers/index.php';
    }
}
