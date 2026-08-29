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
<form class="login" action="<?= url('auth/register') ?>" method="POST">
    <h2>Registrate</h2>
    <?php if (!empty($mensaje)): ?><p style="color:red;text-align:center"><?= e($mensaje) ?></p><?php endif; ?>
    <div class="contenedor-form">
        <select name="tipo_documento" required>
            <option value="">Tipo Documento</option>
            <option value="CC">Cédula de Ciudadanía</option>
            <option value="CE">Cédula Extranjería</option>
            <option value="TI">TI</option>
        </select>
        <input type="text" placeholder="Documento" name="documento" required>
        <input type="text" placeholder="Nombres" name="nombre" required>
        <input type="text" placeholder="Apellidos" name="apellido" required>
        <input type="email" placeholder="Correo Electrónico" name="Correo" required>
        <input type="password" placeholder="Contraseña" name="Contraseña" required>
        <input type="password" placeholder="Confirmar Contraseña" name="Confirmar" required>
        <label><input type="checkbox" name="tratamiento-datos" required> Acepto tratamiento de datos</label>
        <button class="btn-ingresar" type="submit" name="registro">Registrar</button>
    </div>
</form>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body>
</html>
