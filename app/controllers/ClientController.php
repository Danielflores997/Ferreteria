<?php

class ClientController
{
    public function profile(): void
    {
        session_start();

        if (!isset($_SESSION['correo'])) {
            header('Location: ../public/login.php');
            exit();
        }

        require __DIR__ . '/../views/client/profile.php';
    }
}
