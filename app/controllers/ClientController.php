<?php
require_once __DIR__ . '/../models/ClientModel.php';
require_once __DIR__ . '/../core/Tenant.php';

class ClientController
{
    public function profile(): void
    {
        if (!isset($_SESSION['correo'])) {
            header('Location: ../public/login.php?tenant=' . urlencode(Tenant::slug()));
            exit();
        }
        require __DIR__ . '/../views/client/profile.php';
    }

    public function registerForm(): void
    {
        // Esta vista la crearemos en el paso 4
        require __DIR__ . '/../views/client/register.php';
    }

    public function register(): void
    {
        $datos = [
            'tipoDocumento' => $_POST['tipoDocumento'] ?? 'CC',
            'documento' => trim($_POST['documento'] ?? ''),
            'nombres' => trim($_POST['nombres'] ?? ''),
            'apellidos' => trim($_POST['apellidos'] ?? ''),
            'telefono' => trim($_POST['telefono'] ?? ''),
            'direccion' => trim($_POST['direccion'] ?? ''),
            'correo' => trim($_POST['correo'] ?? ''),
            'clave' => $_POST['clave'] ?? ''
        ];

        // Validación básica
        if (empty($datos['documento']) || empty($datos['correo']) || empty($datos['clave'])) {
            header('Location: ../public/registroCliente.php?tenant=' . urlencode(Tenant::slug()) . '&error=Todos los campos son obligatorios');
            exit();
        }

        $model = new ClientModel();

        // Intentar registrar en la tabla cliente
        if (!$model->registrarCliente($datos, Tenant::id())) {
            header('Location: ../public/registroCliente.php?tenant=' . urlencode(Tenant::slug()) . '&error=El documento ya está registrado en esta ferretería');
            exit();
        }

        // Intentar registrar en la tabla usuario
        if (!$model->registrarUsuario($datos, Tenant::id())) {
            header('Location: ../public/registroCliente.php?tenant=' . urlencode(Tenant::slug()) . '&error=El correo ya está registrado');
            exit();
        }

        // Obtener el slug del tenant actual para asegurar la redirección
        $tenantActual = Tenant::current();
        $slug = $tenantActual ? urlencode($tenantActual['slug']) : 'meissen';

        header('Location: ../public/login.php?tenant=' . $slug . '&success=Registro exitoso, por favor inicia sesión');
        exit();
    }
}