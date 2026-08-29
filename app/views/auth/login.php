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
<form class="login" action="<?= url('auth/login') ?>" method="POST">
    <h2>Iniciar Sesión</h2>
    <?php if (!empty($error)): ?><p style="color:red;text-align:center"><?= e($error) ?></p><?php endif; ?>
    <div class="contenedor-form">
        <label><i class="fa-solid fa-user"></i>
            <input type="email" placeholder="Correo Electrónico" name="Correo" required>
        </label>
        <label><i class="fa-solid fa-key"></i>
            <input type="password" placeholder="Contraseña" name="Contraseña" required>
        </label>
        <button class="btn-ingresar" type="submit">Ingresar</button>
    </div>
</form>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body>
</html>
