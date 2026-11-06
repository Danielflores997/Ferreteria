<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 3) {
    header('Location: landing.php');
    exit();
}

require_once __DIR__ . '/../app/config/database.php';
$conn = db();

$result = mysqli_query($conn, 'SELECT * FROM tenants ORDER BY fecha_creacion DESC');
$tenants = $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel SuperAdmin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/superadmin.css">
</head>
<body>

    <!-- Navbar Superior -->
    <div class="admin-navbar">
        <div class="container d-flex justify-content-between align-items-center">
            <h2><i class="fa-solid fa-crown text-warning me-2"></i>Panel SuperAdmin</h2>
            <div>
                <a href="registroFerreteria.php" class="btn-nueva me-2">
                    <i class="fa-solid fa-plus"></i> Nueva Ferretería
                </a>
                <a href="logout.php" class="btn-logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Salir
                </a>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="container pb-5">
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> Ferretería creada exitosamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="admin-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">Ferreterías Registradas</h5>
                <span class="text-muted small">Total: <?= count($tenants) ?></span>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="10%">Logo</th>
                            <th>Nombre Comercial</th>
                            <th>Ruta (Slug)</th>
                            <th>Estado</th>
                            <th width="15%" class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tenants as $t): ?>
                        <tr>
                            <td class="fw-bold text-muted">#<?= $t['idTenant'] ?></td>
                            <td>
                                <?php if (!empty($t['logo'])): ?>
                                    <img src="<?= htmlspecialchars($t['logo']) ?>" class="tenant-logo" alt="logo">
                                <?php else: ?>
                                    <div class="tenant-logo d-flex align-items-center justify-content-center text-muted">
                                        <i class="fa-solid fa-store"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="fw-semibold"><?= htmlspecialchars($t['nombre']) ?></td>
                            <td><code class="text-primary">/<?= htmlspecialchars($t['slug']) ?></code></td>
                            <td>
                                <span class="badge-activo">
                                    <i class="fa-solid fa-circle text-success me-1" style="font-size: 8px;"></i>
                                    <?= $t['estado'] ?>
                                </span>
                                <td class="text-end">
                                <a href="editarFerreteria.php?id=<?= $t['idTenant'] ?>" class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="../Php/index.php?tenant=<?= urlencode($t['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Ver">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>