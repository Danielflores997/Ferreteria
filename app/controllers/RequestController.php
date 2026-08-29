<?php

class RequestController
{
    public function index(): void
    {
        session_start();

        if (!isset($_SESSION['correo'])) {
            header('Location: ../public/login.php');
            exit();
        }

        require __DIR__ . '/../views/requests/index.php';
    }
}
