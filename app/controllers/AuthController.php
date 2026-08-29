<?php
class AuthController extends Controller
{
    public function login()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = trim($_POST['Correo'] ?? '');
            $clave = $_POST['Contraseña'] ?? '';
            $usuarioModel = $this->model('Usuario');
            $usuario = $usuarioModel->autenticar($correo, $clave);

            if ($usuario) {
                if (($usuario['estadoUsuario'] ?? 'Activo') !== 'Activo') {
                    $this->view('auth/inactivo', ['title' => 'Usuario inactivo', 'css' => ['css/mensajes.css']]);
                    return;
                }
                $_SESSION['correo'] = $usuario['correo'];
                $_SESSION['rol'] = (int)$usuario['rol_idRol'];
                $_SESSION['idUsuario'] = (int)$usuario['idUsuario'];

                $rol = (int)$usuario['rol_idRol'];
                if ($rol === 1 || $rol === 2) {
                    $this->redirect('admin/index');
                }
                $this->redirect('cliente/perfil');
            }
            $error = 'Correo o contraseña incorrectos';
        }

        $this->view('auth/login', [
            'title' => 'Iniciar sesión',
            'error' => $error,
            'css' => ['css/loginCliente.css', 'css/menu.css', 'css/footer.css']
        ]);
    }

    public function register()
    {
        $mensaje = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'tipoDocumento' => $_POST['tipo_documento'] ?? '',
                'documento' => trim($_POST['documento'] ?? ''),
                'nombres' => trim($_POST['nombre'] ?? ''),
                'apellidos' => trim($_POST['apellido'] ?? ''),
                'correo' => trim($_POST['Correo'] ?? ''),
                'clave' => $_POST['Contraseña'] ?? '',
            ];
            $confirmar = $_POST['Confirmar'] ?? '';

            if (in_array('', $data, true)) {
                $mensaje = 'Todos los campos son obligatorios.';
            } elseif (!is_numeric($data['documento'])) {
                $mensaje = 'El documento solo debe contener números.';
            } elseif ($data['clave'] !== $confirmar) {
                $mensaje = 'Las contraseñas no coinciden.';
            } else {
                $usuarioModel = $this->model('Usuario');
                if ($usuarioModel->documentoExists($data['documento'])) {
                    $mensaje = 'El número de documento ya está registrado.';
                } elseif ($usuarioModel->findByCorreo($data['correo'])) {
                    $mensaje = 'El correo ya está registrado.';
                } elseif ($usuarioModel->registrar($data)) {
                    $this->redirect('auth/login');
                } else {
                    $mensaje = 'Error al registrar el usuario.';
                }
            }
        }

        $this->view('auth/register', [
            'title' => 'Registro',
            'mensaje' => $mensaje,
            'css' => ['css/registroCliente.css', 'css/menu.css', 'css/footer.css']
        ]);
    }

    public function recuperar()
    {
        $mensaje = '';
        $ok = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = trim($_POST['Correo'] ?? '');
            $nueva = $_POST['Contraseña'] ?? '';
            $confirmar = $_POST['Confirmar'] ?? '';

            if ($correo === '' || $nueva === '' || $confirmar === '') {
                $mensaje = 'Completa todos los campos.';
            } elseif ($nueva !== $confirmar) {
                $mensaje = 'Las contraseñas no coinciden.';
            } else {
                $usuarioModel = $this->model('Usuario');
                $usuario = $usuarioModel->findByCorreo($correo);
                if (!$usuario) {
                    $mensaje = 'No existe un usuario con ese correo.';
                } elseif ($usuarioModel->updatePasswordByCorreo($correo, $nueva)) {
                    $mensaje = 'Contraseña actualizada. Ya puedes iniciar sesión.';
                    $ok = true;
                } else {
                    $mensaje = 'No se pudo actualizar la contraseña.';
                }
            }
        }

        $this->view('auth/recuperar', [
            'title' => 'Recuperar contraseña',
            'mensaje' => $mensaje,
            'ok' => $ok,
            'css' => ['css/loginCliente.css', 'css/mensajes.css', 'css/menu.css', 'css/footer.css']
        ]);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        $this->redirect('home/index');
    }
}
