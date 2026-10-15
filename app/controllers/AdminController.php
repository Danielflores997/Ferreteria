<?php

class AdminController
{
    public function dashboard(): void
    {
        session_start();

        if (!isset($_SESSION['correo'])) {
            header('Location: ../public/login.php');
            exit();
        }

        require __DIR__ . '/../views/admin/dashboard.php';
    }
}
