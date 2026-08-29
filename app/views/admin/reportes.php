<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<?php foreach (($css ?? []) as $c): ?><link rel="stylesheet" href="<?= asset($c) ?>"><?php endforeach; ?>
<title><?= e($title ?? 'Reportes') ?></title>
</head>
<body>
<div class="encabezado">
    <header>
        <div class="titulo"><h1>FERRETERIA MEISSEN</h1></div>
        <div class="logo"><img src="<?= asset('imagenes/ferreteria.jpeg') ?>" alt="logo"></div>
    </header>
    <nav class="navbar"><div class="lista">
        <button class="btn-login"><a class="btn-login" href="<?= url('auth/logout') ?>">Cerrar Sesión</a></button>
    </div></nav>
</div>
<div id="contenedor">
<?php require APP_PATH . '/views/partials/menu_lateral.php'; ?>
<div class="admin-main">
<h2>Reportes</h2>

<div class="panel">
    <h3><i class="fas fa-chart-simple"></i> Resumen general</h3>
    <div class="resumen-linea">
        <div><span>Productos</span><strong><?= (int)($totals['productos'] ?? 0) ?></strong></div>
        <div><span>Ventas</span><strong><?= (int)($totals['ventas'] ?? 0) ?></strong></div>
        <div><span>Monto total</span><strong>$ <?= money($totals['monto_ventas'] ?? 0) ?></strong></div>
    </div>
</div>

<div class="panel">
    <h3><i class="fas fa-boxes-stacked"></i> Inventario</h3>
    <div class="reportes-grid">
        <a class="reporte-card" href="<?= url('admin/reporteInventarioHtml') ?>" target="_blank" rel="noopener">
            <i class="fas fa-file-lines"></i>
            <strong>Ver reporte de inventario</strong>
            <span>Vista HTML lista para imprimir</span>
        </a>
        <a class="reporte-card" href="<?= url('admin/reporteInventario') ?>">
            <i class="fas fa-file-csv"></i>
            <strong>Descargar inventario CSV</strong>
            <span>Compatible con Excel</span>
        </a>
    </div>
</div>

<div class="panel">
    <h3><i class="fas fa-cash-register"></i> Ventas</h3>
    <div class="reportes-grid">
        <a class="reporte-card" href="<?= url('admin/reporteVentasHtml') ?>" target="_blank" rel="noopener">
            <i class="fas fa-file-lines"></i>
            <strong>Ver reporte de ventas</strong>
            <span>Vista HTML lista para imprimir</span>
        </a>
        <a class="reporte-card" href="<?= url('admin/reporteVentas') ?>">
            <i class="fas fa-file-csv"></i>
            <strong>Descargar ventas CSV</strong>
            <span>Compatible con Excel</span>
        </a>
    </div>
</div>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
