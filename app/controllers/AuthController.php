<?php

require_once __DIR__ . '/../models/UserModel.php';

class AuthController
{
    public function loginForm(): void
    {
        require __DIR__ . '/../views/auth/login.php';
    }

    public function authenticate(): void
    {
        session_start();

        $correo = $_POST['Correo'] ?? '';
        $password = $_POST['Contraseña'] ?? '';

        $model = new UserModel();
        $usuario = $model->login($correo, $password);

        if (!$usuario) {
            header('Location: login.php?error=1');
            exit();
        }

        if ($usuario['estadoUsuario'] !== 'Activo') {
            header('Location: ../public/usuarioInactivo.php');
            exit();
        }

        $_SESSION['correo'] = $correo;
        $_SESSION['rol'] = $usuario['rol_idRol'];

        if ((int)$usuario['rol_idRol'] === 1) {
            header('Location: ../public/admin.php');
        } elseif ((int)$usuario['rol_idRol'] === 2) {
            header('Location: ../public/ventas.php');
        } else {
            header('Location: ../public/perfilCliente.php');
        }
        exit();
    }

    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ../public/index.php');
        exit();
    }
}
