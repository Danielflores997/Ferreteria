<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';

$controller = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->authenticate();
} else {
    $controller->loginForm();
}
