<?php

require_once __DIR__ . '/../models/ProviderModel.php';

class InventoryController
{
    public function index(): void
    {
        session_start();

        if (!isset($_SESSION['correo'])) {
            header('Location: ../public/login.php');
            exit();
        }

        $provider = null;
        if (isset($_POST['idProveedor']) && !empty($_POST['idProveedor'])) {
            $model = new ProviderModel();
            $provider = $model->getProviderById((int) $_POST['idProveedor']);

            if ($provider) {
                header('Content-Type: application/json');
                echo json_encode($provider);
                exit();
            }

            echo json_encode(null);
            exit();
        }

        require __DIR__ . '/../views/inventory/index.php';
    }
}
