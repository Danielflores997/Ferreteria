<?php
class App
{
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (!empty($url[0])) {
            $controllerName = ucfirst(strtolower($url[0])) . 'Controller';
            $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';
            if (file_exists($controllerFile)) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        require_once APP_PATH . '/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl()
    {
        $raw = '';

        if (!empty($_GET['url'])) {
            $raw = $_GET['url'];
        } elseif (!empty($_SERVER['PATH_INFO'])) {
            $raw = ltrim($_SERVER['PATH_INFO'], '/');
        } elseif (!empty($_SERVER['REQUEST_URI'])) {
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $base = rtrim(parse_url(BASE_URL, PHP_URL_PATH) ?: '', '/');
            if ($base && strpos($path, $base) === 0) {
                $path = substr($path, strlen($base));
            }
            $raw = ltrim($path, '/');
            // strip index.php prefix if present
            if (stripos($raw, 'index.php/') === 0) {
                $raw = substr($raw, strlen('index.php/'));
            } elseif (strtolower($raw) === 'index.php') {
                $raw = '';
            }
        }

        $raw = trim($raw, '/');
        if ($raw === '') {
            return [];
        }

        // keep only safe path chars
        $raw = preg_replace('#\.\.+#', '', $raw);
        $parts = array_values(array_filter(explode('/', $raw), 'strlen'));
        return array_map(function ($p) {
            return rawurldecode($p);
        }, $parts);
    }
}
