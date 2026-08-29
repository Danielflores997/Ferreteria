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

    protected function rolNombre()
    {
        $rol = isset($_SESSION['rol']) ? (int)$_SESSION['rol'] : 0;
        if ($rol === 1) return 'Administrador';
        if ($rol === 2) return 'Vendedor';
        return 'Cliente';
    }
}
