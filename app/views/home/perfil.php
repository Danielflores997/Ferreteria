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
<div class="cliente-wrap">
    <h2>Mi perfil</h2>

    <div class="cliente-panel">
        <div class="perfil-header">
            <img src="<?= e($fotoPerfil ?: DEFAULT_AVATAR) ?>" alt="Foto de perfil">
            <div class="datos">
                <h3><?= $usuario ? e($usuario['nombresUsuario'] . ' ' . $usuario['apellidosUsuario']) : 'Usuario' ?></h3>
                <span><?= e($_SESSION['correo'] ?? '') ?></span>
            </div>
        </div>
    </div>

    <?php if ($usuario): ?>
    <div class="cliente-panel">
        <h3><i class="fas fa-id-card"></i> Datos personales</h3>
        <div class="cliente-datos">
            <div><span>Nombre</span><strong><?= e($usuario['nombresUsuario'] . ' ' . $usuario['apellidosUsuario']) ?></strong></div>
            <div><span>Correo</span><strong><?= e($usuario['correo']) ?></strong></div>
            <div><span>Documento</span><strong><?= e($usuario['tipoDocumentoUsuario'] . ' ' . $usuario['documentoUsuario']) ?></strong></div>
            <div><span>Estado</span><span class="pill <?= $usuario['estadoUsuario'] === 'Activo' ? 'ok' : '' ?>"><?= e($usuario['estadoUsuario']) ?></span></div>
        </div>
    </div>
    <?php endif; ?>

    <div class="cliente-panel">
        <h3><i class="fas fa-camera"></i> Foto de perfil</h3>
        <form action="<?= url('cliente/actualizarFoto') ?>" method="POST" enctype="multipart/form-data">
            <div class="foto-actual">
                <img id="preview-foto" src="<?= e($fotoPerfil ?: DEFAULT_AVATAR) ?>" alt="Vista previa">
                <div class="cliente-form" style="flex:1">
                    <div class="campo">
                        <label for="archivo">Subir imagen (máx. 2 MB)</label>
                        <input type="file" id="archivo" name="archivo" accept="image/png,image/jpeg,image/webp,image/gif">
                    </div>
                    <div class="campo">
                        <label for="foto">O usar una URL</label>
                        <input type="url" id="foto" name="foto" placeholder="https://...">
                    </div>
                </div>
            </div>
            <div class="cliente-acciones">
                <button type="submit" class="btn-cliente"><i class="fas fa-save"></i> Guardar</button>
                <button type="submit" class="btn-cliente secundario" name="quitar" value="1"><i class="fas fa-rotate-left"></i> Restablecer</button>
            </div>
        </form>
    </div>

    <div class="cliente-acciones">
        <a class="btn-cliente secundario" href="<?= url('cliente/misCompras') ?>"><i class="fas fa-bag-shopping"></i> Mis compras</a>
        <a class="btn-cliente secundario" href="<?= url('cliente/carrito') ?>"><i class="fas fa-cart-shopping"></i> Carrito</a>
        <a class="btn-cliente" href="<?= url('auth/logout') ?>"><i class="fas fa-right-from-bracket"></i> Cerrar sesión</a>
    </div>
</div>
<script>
document.getElementById('archivo').addEventListener('change', function () {
    if (this.files && this.files[0]) {
        document.getElementById('preview-foto').src = URL.createObjectURL(this.files[0]);
    }
});
</script>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
