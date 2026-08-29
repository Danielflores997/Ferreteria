<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte Inventario</title>
<style>
body{font-family:Arial,sans-serif;padding:20px}
table{width:100%;border-collapse:collapse}
th,td{border:1px solid #333;padding:6px;font-size:12px}
th{background:#eee}
h1{margin-bottom:4px}
@media print{.no-print{display:none}}
</style>
</head>
<body>
<button class="no-print" onclick="window.print()">Imprimir / PDF</button>
<a class="no-print" href="<?= url('admin/reporteInventario') ?>">CSV</a>
<h1>Reporte de Inventario — Ferreteria Meissen</h1>
<p>Generado: <?= date('Y-m-d H:i') ?></p>
<table>
<tr><th>Código</th><th>Producto</th><th>Precio</th><th>Stock</th><th>Descripción</th><th>Categoría</th></tr>
<?php foreach (($productos ?? []) as $p): ?>
<tr>
<td><?= e($p['codigoProducto']) ?></td>
<td><?= e($p['nombreProductos']) ?></td>
<td><?= e($p['valorProducto']) ?></td>
<td><?= e($p['stockProducto']) ?></td>
<td><?= e($p['descripcionProducto']) ?></td>
<td><?= e($p['categoriaNombre'] ?? '') ?></td>
</tr>
<?php endforeach; ?>
</table>
</body></html>
