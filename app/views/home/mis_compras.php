<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<?php foreach (($css ?? []) as $c): ?><link rel="stylesheet" href="<?= asset($c) ?>"><?php endforeach; ?>
<title><?= e($title) ?></title>
</head>
<body>
<?php require APP_PATH . '/views/partials/menu_publico.php'; ?>
<div class="cliente-wrap">
    <h2>Mis compras</h2>
    <div class="cliente-tabla">
        <table>
            <thead>
                <tr><th>ID</th><th>Producto</th><th>Cantidad</th><th>Fecha</th></tr>
            </thead>
            <tbody>
            <?php if (empty($compras)): ?>
                <tr><td colspan="4" class="cliente-vacio">Aún no tienes compras registradas.</td></tr>
            <?php else: foreach ($compras as $c): ?>
                <tr>
                    <td><?= e($c['id']) ?></td>
                    <td><?= e($c['producto']) ?></td>
                    <td><?= e($c['cantidad']) ?></td>
                    <td><?= e($c['fecha']) ?></td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
    <div class="cliente-acciones">
        <a class="btn-cliente secundario" href="<?= url('cliente/perfil') ?>"><i class="fas fa-user"></i> Mi perfil</a>
        <a class="btn-cliente" href="<?= url('cliente/carrito') ?>"><i class="fas fa-cart-shopping"></i> Ir al carrito</a>
    </div>
</div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
