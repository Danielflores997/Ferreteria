<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<?php foreach (($css ?? []) as $c): ?><link rel="stylesheet" href="<?= asset($c) ?>"><?php endforeach; ?>
<title><?= e($title) ?></title>
</head>
<body>
<?php require APP_PATH . '/views/partials/menu_publico.php'; ?>
<section style="padding:2rem;max-width:600px;margin:auto">
    <h2>PQRS / Contacto</h2>
    <?php if (!empty($mensaje)): ?><p><?= e($mensaje) ?></p><?php endif; ?>
    <form method="POST" action="<?= url('contacto/index') ?>">
        <input name="nombre" placeholder="Nombre" required>
        <input name="apellido" placeholder="Apellido" required>
        <input name="direccion" placeholder="Dirección">
        <input name="telefono" placeholder="Teléfono">
        <input name="correo" type="email" placeholder="Correo" required>
        <textarea name="motivo" placeholder="Motivo" required></textarea>
        <button type="submit">Enviar</button>
    </form>
</section>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
