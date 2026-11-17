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
    <section class="auth-promo auth-promo--register">
        <div class="auth-promo-mark"><i class="fa-solid fa-hammer" aria-hidden="true"></i></div>
        <p class="auth-eyebrow">EMPIEZA HOY</p>
        <h1>Una cuenta para todos tus proyectos.</h1>
        <p class="auth-promo-copy">Crea tu cuenta para descubrir productos, guardar tus compras y encontrar ferreterías cerca de ti.</p>
        <div class="auth-promo-points">
            <span><i class="fa-solid fa-box-open" aria-hidden="true"></i> Explora el catálogo</span>
            <span><i class="fa-solid fa-receipt" aria-hidden="true"></i> Consulta tus compras</span>
        </div>
    </section>

    <form class="login auth-card auth-card--register" action="<?= url('auth/register') ?>" method="POST">
        <div class="auth-card-heading">
            <span class="auth-card-icon"><i class="fa-solid fa-user-plus" aria-hidden="true"></i></span>
            <div>
                <h2>Crea tu cuenta</h2>
                <p>Completa tus datos para registrarte.</p>
            </div>
        </div>
        <?php if (!empty($mensaje)): ?><p class="auth-alert" role="alert"><?= e($mensaje) ?></p><?php endif; ?>
        <div class="contenedor-form auth-form auth-form--register">
            <label class="auth-control">
                <span>Tipo de documento</span>
                <select name="tipo_documento" required>
                    <option value="">Selecciona una opción</option>
                    <option value="CC">Cédula de ciudadanía</option>
                    <option value="CE">Cédula de extranjería</option>
                    <option value="TI">Tarjeta de identidad</option>
                </select>
            </label>
            <label class="auth-control">
                <span>Documento</span>
                <input type="text" placeholder="Número de documento" name="documento" required>
            </label>
            <label class="auth-control">
                <span>Nombres</span>
                <input type="text" placeholder="Tus nombres" name="nombre" autocomplete="given-name" required>
            </label>
            <label class="auth-control">
                <span>Apellidos</span>
                <input type="text" placeholder="Tus apellidos" name="apellido" autocomplete="family-name" required>
            </label>
            <label class="auth-control auth-control--wide">
                <span>Correo electrónico</span>
                <input type="email" placeholder="nombre@correo.com" name="Correo" autocomplete="email" required>
            </label>
            <label class="auth-control auth-control--wide">
                <span>Contraseña</span>
                <input type="password" placeholder="Mínimo 12 caracteres" name="Contraseña" minlength="12" required autocomplete="new-password">
            </label>
            <label class="auth-control auth-control--wide">
                <span>Confirmar contraseña</span>
                <input type="password" placeholder="Escribe de nuevo tu contraseña" name="Confirmar" minlength="12" required autocomplete="new-password">
            </label>
            <label class="auth-consent auth-control--wide">
                <input type="checkbox" name="tratamiento-datos" required>
                <span>Acepto el tratamiento de datos personales.</span>
            </label>
            <button class="btn-ingresar auth-submit auth-control--wide" type="submit" name="registro">Crear cuenta <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
            <p class="auth-switch auth-control--wide">¿Ya tienes una cuenta? <a href="<?= url('auth/login') ?>">Inicia sesión</a></p>
        </div>
    </form>
</main>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body>
</html>
