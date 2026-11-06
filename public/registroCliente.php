<?php
session_start();
require_once __DIR__ . '/../app/core/Tenant.php';
Tenant::resolve();

// TRUCO: Si el formulario envía el tenant por POST, lo pasamos a GET para que resolve() lo lea
if (!empty($_POST['tenant'])) {
    $_GET['tenant'] = $_POST['tenant'];
}

Tenant::resolve();

require_once __DIR__ . '/../app/controllers/ClientController.php';

$controller = new ClientController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->register();
} else {
    $controller->registerForm();
}