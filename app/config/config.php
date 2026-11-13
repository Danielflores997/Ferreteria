<?php
define('BASE_PATH', dirname(__DIR__, 2));
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', BASE_PATH . '/public');

$aiConfig = [
    'AI_GEMINI_API_KEY' => getenv('AI_GEMINI_API_KEY'),
    'AI_GEMINI_MODEL' => getenv('AI_GEMINI_MODEL'),
];
$localEnvFile = BASE_PATH . '/.env';
if (is_file($localEnvFile)) {
    if (!is_readable($localEnvFile)) {
        throw new RuntimeException('No se puede leer el archivo .env local.');
    }

    $envLines = file($localEnvFile, FILE_IGNORE_NEW_LINES);
    if ($envLines === false) {
        throw new RuntimeException('No se pudo cargar el archivo .env local.');
    }

    foreach ($envLines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
            continue;
        }

        [$name, $value] = explode('=', $line, 2);
        $name = trim($name);
        if (!array_key_exists($name, $aiConfig)) {
            continue;
        }

        $value = trim($value);
        if (strlen($value) >= 2 && (($value[0] === '"' && substr($value, -1) === '"') || ($value[0] === "'" && substr($value, -1) === "'"))) {
            $value = substr($value, 1, -1);
        }
        if (($aiConfig[$name] === false || $aiConfig[$name] === '') && $value !== '') {
            $aiConfig[$name] = $value;
        }
    }
}

define('AI_GEMINI_API_KEY', trim((string)($aiConfig['AI_GEMINI_API_KEY'] ?: '')));
define('AI_GEMINI_MODEL', trim((string)($aiConfig['AI_GEMINI_MODEL'] ?: 'gemini-3.5-flash-lite')));

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
