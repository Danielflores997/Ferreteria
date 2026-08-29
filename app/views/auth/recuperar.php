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
<form class="login" action="<?= url('auth/recuperar') ?>" method="POST">
    <h2>Recuperar / Restablecer contraseña</h2>
    <?php if (!empty($mensaje)): ?>
        <p style="color:<?= !empty($ok) ? 'green' : 'red' ?>;text-align:center"><?= e($mensaje) ?></p>
    <?php endif; ?>
    <div class="contenedor-form">
        <label><i class="fa-solid fa-envelope"></i>
            <input type="email" name="Correo" placeholder="Correo registrado" required>
        </label>
        <label><i class="fa-solid fa-key"></i>
            <input type="password" name="Contraseña" placeholder="Nueva contraseña" required>
        </label>
        <label><i class="fa-solid fa-key"></i>
            <input type="password" name="Confirmar" placeholder="Confirmar contraseña" required>
        </label>
        <button class="btn-ingresar" type="submit">Restablecer</button>
        <p style="text-align:center"><a href="<?= url('auth/login') ?>">Volver al login</a></p>
    </div>
</form>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body>
</html>
