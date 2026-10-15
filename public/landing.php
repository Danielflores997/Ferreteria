<?php
session_start();
require_once __DIR__ . '/../app/config/database.php';

$conn = db();
$result = mysqli_query($conn, 'SELECT * FROM tenants WHERE estado = "Activo" ORDER BY nombre');
$tenants = $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elige tu Ferretería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/landing.css">
</head>

<body>

    <div class="container py-4">
        <div class="hero">
            <h1>Bienvenido a <span class="accent">Ferreterías</span> Multi-Tenant</h1>
            <p>Selecciona la ferretería a la que deseas ingresar</p>
        </div>

        <?php if (count($tenants) === 0): ?>
            <div class="empty-state">
                <i class="fa-solid fa-store-slash fa-3x mb-3"></i>
                <h4>No hay ferreterías registradas</h4>
                <p>Registra la primera ferretería para comenzar.</p>
            </div>
        <?php else: ?>
            <div class="row g-4 justify-content-center">
                <?php foreach ($tenants as $t): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="tenant-card">
                            <div class="card-img-wrap">
                                <img src="<?= htmlspecialchars($t['logo'] ?: '/Ferreteria-mvc/imagenes/ferreteria.jpeg') ?>"
                                    alt="<?= htmlspecialchars($t['nombre']) ?>">
                            </div>
                            <div class="card-body">
                                <h5><?= htmlspecialchars($t['nombre']) ?> <i class="fa-solid fa-store me-2"
                                        style="color:#AC1E1E;"></i> </h5>
                                <?php if (!empty($t['direccion'])): ?>
                                    <div class="meta">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <?= htmlspecialchars($t['direccion']) ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($t['telefono'])): ?>
                                    <div class="meta">
                                        <i class="fa-solid fa-phone"></i>
                                        <?= htmlspecialchars($t['telefono']) ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($t['correo'])): ?>
                                    <div class="meta">
                                        <i class="fa-solid fa-envelope"></i>
                                        <?= htmlspecialchars($t['correo']) ?>
                                    </div>
                                <?php endif; ?>
                                <a class="btn-enter mt-3" href="../Php/index.php?tenant=<?= urlencode($t['slug']) ?>">
                                    <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>
                                    Entrar a esta ferretería
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="text-center">
            <a href="registroFerreteria.php" class="btn-register">
                <i class="fa-solid fa-plus me-2"></i>Registrar nueva ferretería
            </a>
        </div>

        <p class="text-center mt-4" style="opacity:.6;font-size:.85rem;">
            &copy; <?= date('Y') ?> Plataforma Multi-Tenant de Ferreterías
        </p>
    </div>

</body>

</html>