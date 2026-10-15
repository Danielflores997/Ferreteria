<?php

require_once __DIR__ . '/../models/UserAdminModel.php';

class UserAdminController
{
    public function index(): void
    {
        session_start();

        if (!isset($_SESSION['correo'])) {
            header('Location: ../public/login.php');
            exit();
        }

        $model = new UserAdminModel();
        $users = $model->getAllUsers();

        require __DIR__ . '/../views/user/index.php';
    }
}
