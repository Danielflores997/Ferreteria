<?php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../core/Tenant.php';

class AuthController
{
    public function loginForm(): void
    {
        require __DIR__ . '/../views/auth/login.php';
    }

    public function authenticate(): void
    {
        // Resuelve el tenant activo antes de procesar el login
        if (!empty($_POST['tenant'])) {
            $_GET['tenant'] = $_POST['tenant'];
            Tenant::resolve();
        }

        $correo = trim($_POST['Correo'] ?? '');
        $password = $_POST['Contraseña'] ?? '';

        if ($correo === '' || $password === '') {
            header('Location: ../public/login.php?tenant=' . urlencode(Tenant::slug()) . '&error=Campos obligatorios');
            exit();
        }

        $model = new UserModel();
        $usuario = $model->login($correo, $password);

        // 1. Usuario no existe o clave incorrecta
        if (!$usuario) {
            header('Location: ../public/login.php?tenant=' . urlencode(Tenant::slug()) . '&error=Correo o contraseña incorrectos');
            exit();
        }

        // 2. Usuario inactivo
        if ($usuario['estadoUsuario'] !== 'Activo') {
            header('Location: ../public/usuarioInactivo.php');
            exit();
        }

        // 3. Usuario no pertenece a esta ferretería
        if ((int) $usuario['tenant_id'] !== (int) Tenant::id()) {
            header('Location: ../public/login.php?tenant=' . urlencode(Tenant::slug()) . '&error=Este usuario no pertenece a esta ferretería');
            exit();
        }

        // 4. Todo OK → guardar sesión
        $_SESSION['usuario_id'] = (int) $usuario['idUsuario'];
        $_SESSION['correo'] = $usuario['correo'];
        $_SESSION['tenant_id'] = (int) $usuario['tenant_id'];
        $_SESSION['rol'] = (int) $usuario['rol_idRol'];
        $_SESSION['nombre'] = $usuario['nombresUsuario'];

        // 5. Redirigir según rol
        $slug = urlencode(Tenant::slug());
        if ((int) $usuario['rol_idRol'] === 1) {
            header("Location: ../public/admin.php?tenant=$slug");
        } elseif ((int) $usuario['rol_idRol'] === 2) {
            header("Location: ../public/ventas.php?tenant=$slug");
        } else {
            header("Location: ../Php/index.php?tenant=$slug");
        }
        exit();
    }

    public function logout(): void
    {
        // session_start() ya se hizo en el entry point
        session_unset();
        session_destroy();
        header('Location: ../public/landing.php');
        exit();
    }
}