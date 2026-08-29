<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <?php if (!empty($css)): foreach ((array)$css as $c): ?>
        <link rel="stylesheet" href="<?= asset($c) ?>">
    <?php endforeach; endif; ?>
    <title><?= e($title ?? 'Admin') ?> | <?= e(APP_NAME) ?></title>
</head>
<body>
<div class="encabezado">
    <header>
        <div class="titulo"><h1>FERRETERIA MEISSEN</h1></div>
        <div class="logo"><img src="<?= asset('imagenes/ferreteria.jpeg') ?>" alt="logo ferreteria"></div>
    </header>
    <nav class="navbar">
        <div class="lista">
            <button class="btn-login">
                <a class="btn-login" href="<?= url('auth/logout') ?>">Cerrar Sesión</a>
            </button>
        </div>
    </nav>
</div>
<div id="contenedor" style="display:flex;">
    <?php require APP_PATH . '/views/partials/menu_lateral.php'; ?>
    <div class="contenido-principal" style="flex:1; padding:1rem;">
        <?= $content ?? '' ?>
    </div>
</div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body>
</html>
