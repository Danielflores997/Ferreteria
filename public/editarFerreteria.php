<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 3) {
    header('Location: landing.php');
    exit();
}

require_once __DIR__ . '/../app/config/database.php';
$conn = db();

$id = $_GET['id'] ?? 0;
$tenant = null;

// Si se envía el formulario, actualizamos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $slug = strtolower(trim($_POST['slug']));
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    
    // Actualizar datos básicos
    $stmt = mysqli_prepare($conn, 'UPDATE tenants SET nombre=?, slug=?, direccion=?, telefono=?, correo=? WHERE idTenant=?');
    mysqli_stmt_bind_param($stmt, 'sssssi', $nombre, $slug, $direccion, $telefono, $correo, $id);
    mysqli_stmt_execute($stmt);
    
    // Si subieron un logo nuevo
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $carpetaDestino = __DIR__ . '/../imagenes/tenants/';
        $nombreArchivo = time() . '_' . basename($_FILES['logo']['name']);
        $rutaTemporal = $_FILES['logo']['tmp_name'];
        
        if (move_uploaded_file($rutaTemporal, $carpetaDestino . $nombreArchivo)) {
            $rutaLogo = '/Ferreteria-mvc/imagenes/tenants/' . $nombreArchivo;
            mysqli_query($conn, "UPDATE tenants SET logo = '$rutaLogo' WHERE idTenant = $id");
        }
    }
    
    header('Location: superadmin.php?updated=1');
    exit();
}

// Obtener datos del tenant para mostrarlos
$stmt = mysqli_prepare($conn, 'SELECT * FROM tenants WHERE idTenant = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$tenant = mysqli_fetch_assoc($result);

if (!$tenant) die("Ferretería no encontrada");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Ferretería - <?= htmlspecialchars($tenant['nombre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/superadmin.css">
</head>
<body>
    <div class="container py-5" style="max-width: 600px;">
        <div class="admin-card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Editar: <?= htmlspecialchars($tenant['nombre']) ?></h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($tenant['nombre']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Slug (URL)</label>
                        <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($tenant['slug']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Dirección</label>
                        <input type="text" name="direccion" class="form-control" value="<?= htmlspecialchars($tenant['direccion'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($tenant['telefono'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label>Correo</label>
                        <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($tenant['correo'] ?? '') ?>">
                    </div>
                    
                    <div class="mb-4">
                        <label>Logo actual</label><br>
                        <?php if(!empty($tenant['logo'])): ?>
                            <img src="<?= htmlspecialchars($tenant['logo']) ?>" class="img-thumbnail mb-2" style="max-height: 100px;">
                        <?php else: ?>
                            <span class="text-muted d-block mb-2">No hay logo</span>
                        <?php endif; ?>
                        
                        <label>Cambiar Logo (Opcional)</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                    <a href="superadmin.php" class="btn btn-link w-100 mt-2">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>