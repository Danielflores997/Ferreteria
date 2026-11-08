<?php
define('BASE_PATH', dirname(__DIR__, 2));
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', BASE_PATH . '/public');

$baseUrl = getenv('APP_BASE_URL');
if ($baseUrl === false) {
    $baseUrl = '/Ferreteria/public';
}

define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'ferreterianuevo');
define('BASE_URL', rtrim($baseUrl, '/'));

// SVG embebido para no depender de un archivo de imagen inexistente
define('DEFAULT_AVATAR', 'data:image/svg+xml;utf8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><rect width="128" height="128" fill="#2b3140"/><circle cx="64" cy="48" r="24" fill="#9aa4b2"/><path d="M16 128c0-26.5 21.5-48 48-48s48 21.5 48 48z" fill="#9aa4b2"/></svg>'));
define('APP_NAME', 'Ferreteria Meissen');
define('PLATFORM_NAME', 'Ferreteria Marketplace');

// Hojas de estilo comunes a todas las vistas del panel administrativo
define('ADMIN_CSS', ['css/vistaAdmin.css', 'css/footer.css', 'css/admin.css']);
