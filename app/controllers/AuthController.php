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

        // --- EXCEPCIÓN PARA SUPERADMIN ---
        if ((int) $usuario['rol_idRol'] === 3 && empty($usuario['tenant_id'])) {
            $_SESSION['usuario_id'] = (int) $usuario['idUsuario'];
            $_SESSION['correo'] = $usuario['correo'];
            $_SESSION['rol'] = 3;
            $_SESSION['nombre'] = $usuario['nombresUsuario'];

            header("Location: ../public/superadmin.php");
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
            // Admin → Panel de admin (cuando lo tengamos listo)
            // Por ahora lo mandamos al catálogo filtrado
            header("Location: ../Php/index.php?tenant=$slug");
        } elseif ((int) $usuario['rol_idRol'] === 2) {
            // Cliente → Catálogo filtrado (en vez de ventas.php)
            header("Location: ../Php/index.php?tenant=$slug");
        } else {
            header("Location: ../Php/index.php?tenant=$slug");
        }
        exit();
    }

    public function logout(): void
    {
        // session_start() ya se hizo en el entry point (logout.php)
        $_SESSION = array(); // Limpiar todas las variables de sesión

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        // Redirección a la landing (desde public/, es solo "landing.php")
        header('Location: landing.php');
        exit();
    }
}