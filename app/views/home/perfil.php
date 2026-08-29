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
<div class="container-perfil">
    <div class="container">
        <h2>Perfil del Usuario</h2>
        <?php if ($usuario): ?>
        <p><strong>Nombre:</strong> <?= e($usuario['nombresUsuario'] . ' ' . $usuario['apellidosUsuario']) ?></p>
        <p><strong>Correo:</strong> <?= e($usuario['correo']) ?></p>
        <p><strong>Tipo de Documento:</strong> <?= e($usuario['tipoDocumentoUsuario']) ?></p>
        <p><strong>Documento:</strong> <?= e($usuario['documentoUsuario']) ?></p>
        <p><strong>Estado:</strong> <?= e($usuario['estadoUsuario']) ?></p>
        <?php endif; ?>
        <form action="<?= url('admin/actualizarFoto') ?>" method="POST">
            <label>Cambiar foto de perfil:</label>
            <input type="url" name="foto" placeholder="Enlace de la imagen">
            <button type="submit">Guardar</button>
        </form>
    </div>
</div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
