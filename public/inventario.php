<?php

session_start();
require_once __DIR__ . '/../app/core/Tenant.php';
Tenant::resolve();

require_once __DIR__ . '/../app/controllers/InventoryController.php';

$controller = new InventoryController();
$controller->index();
