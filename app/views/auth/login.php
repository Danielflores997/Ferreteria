<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<?php foreach (($css ?? []) as $c): ?><link rel="stylesheet" href="<?= asset($c) ?>"><?php endforeach; ?>
<title><?= e($title) ?></title>
</head>
<body class="auth-page">
<?php require APP_PATH . '/views/partials/menu_publico.php'; ?>
<main class="auth-shell">
    <section class="auth-promo auth-promo--login">
        <div class="auth-promo-mark"><i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i></div>
        <p class="auth-eyebrow">MARKETPLACE FERRETERO</p>
        <h1>Todo para construir tus ideas.</h1>
        <p class="auth-promo-copy">Encuentra productos de distintas ferreterías y continúa tus proyectos desde un solo lugar.</p>
        <div class="auth-promo-points">
            <span><i class="fa-solid fa-store" aria-hidden="true"></i> Tiendas locales</span>
            <span><i class="fa-solid fa-basket-shopping" aria-hidden="true"></i> Compra fácil y segura</span>
        </div>
    </section>

    <form class="login auth-card auth-card--login" action="<?= url('auth/login') ?>" method="POST">
        <div class="auth-card-heading">
            <span class="auth-card-icon"><i class="fa-solid fa-user" aria-hidden="true"></i></span>
            <div>
                <h2>¡Qué bueno verte!</h2>
                <p>Ingresa a tu cuenta para continuar.</p>
            </div>
        </div>
        <?php if (!empty($error)): ?><p class="auth-alert" role="alert"><?= e($error) ?></p><?php endif; ?>
        <?php if (!empty($returnToCart)): ?><input type="hidden" name="return" value="cliente/carrito"><?php endif; ?>
        <div class="contenedor-form auth-form">
            <label class="auth-input">
                <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                <span class="sr-only">Correo electrónico</span>
                <input type="email" placeholder="Correo electrónico" name="Correo" autocomplete="username" required>
            </label>
            <label class="auth-input">
                <i class="fa-solid fa-lock" aria-hidden="true"></i>
                <span class="sr-only">Contraseña</span>
                <input type="password" placeholder="Contraseña" name="Contraseña" autocomplete="current-password" required>
            </label>
            <a href="<?= url('auth/recuperar') ?>" class="olvidaste auth-forgot">¿Olvidaste tu contraseña?</a>
            <button class="btn-ingresar auth-submit" type="submit">Ingresar <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
            <p class="auth-switch">¿Aún no tienes cuenta? <a href="<?= url('auth/register') ?>">Regístrate</a></p>
        </div>
    </form>
</main>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body>
</html>
