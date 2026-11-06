<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 3) {
    header('Location: landing.php');
    exit();
}

require_once __DIR__ . '/../app/config/database.php';
$conn = db();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $slug = strtolower(trim($_POST['slug'] ?? ''));
    $direccion = trim($_POST['direccion'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $correo_contacto = trim($_POST['correo_contacto'] ?? '');
    
    $correoAdmin = trim($_POST['correo_admin'] ?? '');
    $claveAdmin = $_POST['clave_admin'] ?? '';
    
    // Lógica para la imagen (Logo)
    $rutaLogo = null;
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $carpetaDestino = __DIR__ . '/../imagenes/tenants/';
        // Creamos un nombre único para evitar sobreescribir imágenes con el mismo nombre
        $nombreArchivo = time() . '_' . basename($_FILES['logo']['name']);
        $rutaTemporal = $_FILES['logo']['tmp_name'];
        
        if (move_uploaded_file($rutaTemporal, $carpetaDestino . $nombreArchivo)) {
            // Guardamos la ruta web absoluta
            $rutaLogo = '/Ferreteria-mvc/imagenes/tenants/' . $nombreArchivo;
        }
    }
    
    if (empty($nombre) || empty($slug) || empty($correoAdmin) || empty($claveAdmin)) {
        $error = 'Nombre, Slug, Correo Admin y Contraseña son obligatorios.';
    } else {
        // 1. Insertar el Tenant con todos los datos
        $stmt = mysqli_prepare($conn, 'INSERT INTO tenants (nombre, slug, logo, direccion, telefono, correo, estado) VALUES (?, ?, ?, ?, ?, ?, "Activo")');
        mysqli_stmt_bind_param($stmt, 'ssssss', $nombre, $slug, $rutaLogo, $direccion, $telefono, $correo_contacto);
        
        if (mysqli_stmt_execute($stmt)) {
            // ... (El resto del código del admin se queda igual)
            $nuevoTenantId = mysqli_insert_id($conn);
            
            $stmtAdmin = mysqli_prepare($conn, 'INSERT INTO usuario (tipoDocumentoUsuario, documentoUsuario, nombresUsuario, apellidosUsuario, correo, claveUsuario, estadoUsuario, rol_idRol, tenant_id) VALUES ("CC", 0, "Admin", ?, ?, ?, "Activo", 1, ?)');
            mysqli_stmt_bind_param($stmtAdmin, 'sssi', $nombre, $correoAdmin, $claveAdmin, $nuevoTenantId);
            mysqli_stmt_execute($stmtAdmin);
            
            header('Location: superadmin.php?success=1');
            exit();
        } else {
            $error = 'Error al crear la ferretería.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Ferretería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5" style="max-width: 600px;">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Nueva Ferretería</h4>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <h5 class="mb-3">Datos de la Ferretería</h5>
                    <div class="mb-3">
                        <label>Nombre Comercial</label>
                        <input type="text" name="nombre" class="form-control" required
                            placeholder="Ej: Ferretería El Martillo">
                    </div>

                    <div class="mb-3">
                        <label>Slug (URL, sin espacios)</label>
                        <input type="text" name="slug" class="form-control" required placeholder="Ej: martillo">
                    </div>

                    <div class="mb-3">
                        <label>Nombre Comercial</label>
                        <input type="text" name="nombre" class="form-control" required
                            placeholder="Ej: Ferretería El Martillo">
                    </div>

                    <div class="mb-3">
                        <label>Slug (URL, sin espacios)</label>
                        <input type="text" name="slug" class="form-control" required placeholder="Ej: martillo">
                    </div>

                    <div class="mb-3">
                        <label>Dirección</label>
                        <input type="text" name="direccion" class="form-control" placeholder="Ej: Calle 10 # 5-20">
                    </div>

                    <div class="mb-3">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control" placeholder="Ej: 3001234567">
                    </div>

                    <div class="mb-3">
                        <label>Correo de Contacto</label>
                        <input type="email" name="correo_contacto" class="form-control"
                            placeholder="Ej: contacto@martillo.com">
                    </div>

                    <div class="mb-3">
                        <label>Logo de la Ferretería (Opcional)</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>

                    <hr>
                    <h5 class="mb-3">Datos del Administrador</h5>
                    <div class="mb-3">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo_admin" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input type="text" name="clave_admin" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Crear Ferretería</button>
                    <a href="superadmin.php" class="btn btn-link w-100 mt-2">Volver al panel</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>