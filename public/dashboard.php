<?php

session_start();
require_once __DIR__ . '/../app/core/Tenant.php';
Tenant::resolve();

require_once __DIR__ . '/../app/controllers/DashboardController.php';

$controller = new DashboardController();
$controller->index();
