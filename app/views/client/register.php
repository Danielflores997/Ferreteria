<?php
// Esta vista la carga ClientController::registerForm()
$error = $_GET['error'] ?? null;
$slug = Tenant::slug();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - <?= htmlspecialchars(Tenant::nombre()) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/login.css">
</head>

<body>

    <div class="login-wrapper" style="max-width: 500px;">
        <div class="login-card">
            <div class="login-header">
                <img src="<?= htmlspecialchars(Tenant::logo()) ?>" alt="logo">
                <h2><?= htmlspecialchars(Tenant::nombre()) ?></h2>
                <p>Crea tu cuenta</p>
            </div>

            <?php if ($error): ?>
                <div class="alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="../app/controllers/ClientController.php?action=register" class="login-form">
                <input type="hidden" name="tenant" value="<?= htmlspecialchars($slug) ?>">

                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <select name="tipoDocumento" class="form-select"
                        style="padding-left:44px;border-radius:12px;padding-top:14px;padding-bottom:14px;border:2px solid #e5e7eb;">
                        <option value="CC">Cédula de Ciudadanía</option>
                        <option value="TI">Tarjeta de Identidad</option>
                        <option value="CE">Cédula de Extranjería</option>
                    </select>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-id-card"></i>
                    <input type="text" name="documento" placeholder="Número de documento" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="nombres" placeholder="Nombres" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="apellidos" placeholder="Apellidos" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-phone"></i>
                    <input type="text" name="telefono" placeholder="Teléfono" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-location-dot"></i>
                    <input type="text" name="direccion" placeholder="Dirección" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="correo" placeholder="Correo electrónico" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="clave" placeholder="Contraseña" required>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-user-plus me-2"></i>Registrarme
                </button>
            </form>

            <div class="login-footer">
                <p>¿Ya tienes cuenta?
                    <a href="../public/login.php?tenant=<?= urlencode($slug) ?>">Inicia sesión</a>
                </p>
                <a href="../public/landing.php" class="back-link">
                    <i class="fa-solid fa-arrow-left me-1"></i>Volver al inicio
                </a>
            </div>
        </div>
    </div>

</body>

</html>