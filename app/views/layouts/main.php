<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <?php if (!empty($css)): foreach ((array)$css as $c): ?>
        <link rel="stylesheet" href="<?= asset($c) ?>">
    <?php endforeach; endif; ?>
    <title><?= e($title ?? APP_NAME) ?> | <?= e(APP_NAME) ?></title>
</head>
<body>
<?php require APP_PATH . '/views/partials/menu_publico.php'; ?>
<?= $content ?? '' ?>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body>
</html>
