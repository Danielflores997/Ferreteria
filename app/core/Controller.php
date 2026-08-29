<?php
class Controller
{
    protected function model($model)
    {
        $path = APP_PATH . '/models/' . $model . '.php';
        if (!file_exists($path)) {
            throw new Exception("Modelo no encontrado: $model");
        }
        require_once $path;
        return new $model();
    }

    protected function view($view, $data = [])
    {
        extract($data);
        $viewFile = APP_PATH . '/views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            die("Vista no encontrada: $view");
        }
        require_once $viewFile;
    }

    protected function json($data, $code = 200)
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    protected function redirect($path)
    {
        header('Location: ' . BASE_URL . '/' . ltrim($path, '/'));
        exit;
    }

    protected function requireLogin()
    {
        if (empty($_SESSION['correo'])) {
            $this->redirect('auth/login');
        }
    }

    protected function requireAdmin()
    {
        $this->requireLogin();
        if (!isset($_SESSION['rol']) || (int)$_SESSION['rol'] !== 1) {
            $this->redirect('home/index');
        }
    }

    protected function requireStaff()
    {
        $this->requireLogin();
        $rol = isset($_SESSION['rol']) ? (int)$_SESSION['rol'] : 0;
        if (!in_array($rol, [1, 2], true)) {
            $this->redirect('home/index');
        }
    }

    protected function currentUserPhoto()
    {
        if (empty($_SESSION['correo'])) {
            return DEFAULT_AVATAR;
        }
        $usuarioModel = $this->model('Usuario');
        $foto = $usuarioModel->getFotoPerfil($_SESSION['correo']);
        return $foto ?: DEFAULT_AVATAR;
    }

    /** Devuelve la URL pública de la imagen subida o null si el archivo no es una imagen válida. */
    protected function guardarFotoSubida($campo = 'archivo')
    {
        if (empty($_FILES[$campo]) || $_FILES[$campo]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $tmp = $_FILES[$campo]['tmp_name'];
        if (!is_uploaded_file($tmp) || $_FILES[$campo]['size'] > 2 * 1024 * 1024) {
            return null;
        }

        $permitidos = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
        ];
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($tmp);
        if (!isset($permitidos[$mime]) || getimagesize($tmp) === false) {
            return null;
        }

        $destinoDir = PUBLIC_PATH . '/uploads/perfiles';
        if (!is_dir($destinoDir) && !mkdir($destinoDir, 0775, true) && !is_dir($destinoDir)) {
            return null;
        }

        $nombre = bin2hex(random_bytes(16)) . '.' . $permitidos[$mime];
        if (!move_uploaded_file($tmp, $destinoDir . '/' . $nombre)) {
            return null;
        }

        return asset('uploads/perfiles/' . $nombre);
    }

    protected function rolNombre()
    {
        $rol = isset($_SESSION['rol']) ? (int)$_SESSION['rol'] : 0;
        if ($rol === 1) return 'Administrador';
        if ($rol === 2) return 'Vendedor';
        return 'Cliente';
    }
}
