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
<section style="padding:2rem;max-width:900px;margin:auto">
    <h2>Nosotros</h2>
    <p>Ferretería Meissen es tu aliado en herramientas, materiales de construcción y soluciones para el hogar y la industria.</p>
    <img src="<?= asset('imagenes/ferreteria.jpeg') ?>" alt="Ferreteria" style="max-width:100%">
</section>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
