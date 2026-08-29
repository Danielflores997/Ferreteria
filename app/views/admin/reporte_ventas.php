<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte Ventas</title>
<style>
body{font-family:Arial,sans-serif;padding:20px}
table{width:100%;border-collapse:collapse}
th,td{border:1px solid #333;padding:6px;font-size:12px}
th{background:#eee}
@media print{.no-print{display:none}}
</style>
</head>
<body>
<button class="no-print" onclick="window.print()">Imprimir / PDF</button>
<a class="no-print" href="<?= url('admin/reporteVentas') ?>">CSV</a>
<h1>Reporte de Ventas — Ferreteria Meissen</h1>
<p>Generado: <?= date('Y-m-d H:i') ?></p>
<table>
<tr><th>ID</th><th>Fecha</th><th>Código</th><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Total</th></tr>
<?php $gran=0; foreach (($ventas ?? []) as $v):
$t=(float)$v['cantidad']*(float)$v['precio_unitario']; $gran+=$t; ?>
<tr>
<td><?= e($v['idVenta']) ?></td>
<td><?= e($v['fecha_venta'] ?? '') ?></td>
<td><?= e($v['idcodigo']) ?></td>
<td><?= e($v['producto']) ?></td>
<td><?= e($v['cantidad']) ?></td>
<td><?= e($v['precio_unitario']) ?></td>
<td><?= e($t) ?></td>
</tr>
<?php endforeach; ?>
<tr><td colspan="6" style="text-align:right"><strong>Total general</strong></td><td><strong><?= e($gran) ?></strong></td></tr>
</table>
</body></html>
