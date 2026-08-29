<?php
session_start();

require_once dirname(__DIR__) . '/app/config/config.php';
require_once APP_PATH . '/config/database.php';
require_once APP_PATH . '/helpers/functions.php';
require_once APP_PATH . '/core/Model.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/App.php';

// Normalize url param if present (may arrive encoded once or twice)
if (isset($_GET['url'])) {
    $_GET['url'] = rawurldecode(str_replace('%2F', '/', $_GET['url']));
    $_GET['url'] = trim($_GET['url'], '/');
}

$app = new App();
