<?php

session_start();
require_once __DIR__ . '/../app/core/Tenant.php';
Tenant::resolve();

require_once __DIR__ . '/../app/controllers/AdminController.php';

$controller = new AdminController();
$controller->dashboard();
