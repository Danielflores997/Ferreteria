<?php
// Este archivo es incluido desde AuthController::loginForm()
// La variable $error viene del query string
$error = $_GET['error'] ?? null;
$slug = Tenant::slug();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - <?= htmlspecialchars(Tenant::nombre()) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/login.css">
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">

            <div class="login-header">
                <img src="<?= htmlspecialchars(Tenant::logo()) ?>" alt="logo">
                <h2><?= htmlspecialchars(Tenant::nombre()) ?></h2>
                <p>Inicia sesión en tu cuenta</p>
            </div>

            <?php if ($error): ?>
                <div class="alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="../public/login.php?tenant=<?= urlencode($slug) ?>" class="login-form">
                <input type="hidden" name="tenant" value="<?= htmlspecialchars($slug) ?>">

                <div class="input-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="Correo" placeholder="Correo electrónico" required autofocus>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="Contraseña" placeholder="Contraseña" required>
                </div>

                <div class="form-footer">
                    <label class="remember">
                        <input type="checkbox" name="recordar">
                        <span>Recordarme</span>
                    </label>
                    <a href="../../public/recoverPassword.php" class="forgot">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Ingresar
                </button>
            </form>

            <div class="login-footer">
                <p>¿No tienes cuenta?
                    <a href="../../public/registroCliente.php?tenant=<?= urlencode($slug) ?>">Regístrate</a>
                </p>
                <a href="../../public/landing.php" class="back-link">
                    <i class="fa-solid fa-arrow-left me-1"></i>Volver a la selección de ferretería
                </a>
            </div>

        </div>
    </div>

</body>

</html>