<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<?php foreach (($css ?? []) as $c): ?><link rel="stylesheet" href="<?= asset($c) ?>"><?php endforeach; ?>
<title><?= e($title ?? 'Admin') ?></title>
</head>
<body>
<div class="encabezado">
    <header>
        <div class="titulo"><h1>FERRETERIA MEISSEN</h1></div>
        <div class="logo"><img src="<?= asset('imagenes/ferreteria.jpeg') ?>" alt="logo"></div>
    </header>
    <nav class="navbar"><div class="lista">
        <button class="btn-login"><a class="btn-login" href="<?= url('auth/logout') ?>">Cerrar Sesión</a></button>
    </div></nav>
</div>
<div id="contenedor">
<?php require APP_PATH . '/views/partials/menu_lateral.php'; ?>
<div class="admin-main">

<h2>Dashboard <?= e($rolNombre ?? '') ?></h2>

<div class="cards">
    <div class="card"><h3>Productos</h3><div class="num"><?= (int)($totals['productos'] ?? 0) ?></div></div>
    <div class="card"><h3>Stock total</h3><div class="num"><?= (int)($totals['stock'] ?? 0) ?></div></div>
    <div class="card"><h3>Bajo stock (&lt;10)</h3><div class="num"><?= (int)($totals['bajo_stock'] ?? 0) ?></div></div>
    <div class="card"><h3>Usuarios</h3><div class="num"><?= (int)($totals['usuarios'] ?? 0) ?></div></div>
    <div class="card"><h3>Clientes</h3><div class="num"><?= (int)($totals['clientes'] ?? 0) ?></div></div>
    <div class="card"><h3>Proveedores</h3><div class="num"><?= (int)($totals['proveedores'] ?? 0) ?></div></div>
    <div class="card"><h3>Ventas</h3><div class="num"><?= (int)($totals['ventas'] ?? 0) ?></div></div>
    <div class="card"><h3>Monto ventas</h3><div class="num">$ <?= money($totals['monto_ventas'] ?? 0) ?></div></div>
    <div class="card"><h3>Compras carrito</h3><div class="num"><?= (int)($totals['compras'] ?? 0) ?></div></div>
    <div class="card"><h3>Peticiones</h3><div class="num"><?= (int)($totals['peticiones'] ?? 0) ?></div></div>
</div>

<div class="grid-2">
    <div class="panel">
        <h3><i class="fas fa-user"></i> Mi perfil</h3>
        <?php if (!empty($usuario)): ?>
        <div class="perfil-datos">
            <div><span>Nombre</span><strong><?= e($usuario['nombresUsuario'].' '.$usuario['apellidosUsuario']) ?></strong></div>
            <div><span>Correo</span><strong><?= e($usuario['correo']) ?></strong></div>
            <div><span>Documento</span><strong><?= e(($usuario['tipoDocumentoUsuario'] ?? '').' '.($usuario['documentoUsuario'] ?? '')) ?></strong></div>
            <div><span>Estado</span><span class="badge <?= ($usuario['estadoUsuario'] ?? '') === 'Activo' ? 'ok' : '' ?>"><?= e($usuario['estadoUsuario'] ?? '') ?></span></div>
            <div><span>Rol</span><span class="badge"><?= e($rolNombre) ?></span></div>
        </div>
        <form action="<?= url('admin/actualizarFoto') ?>" method="POST" enctype="multipart/form-data">
            <div class="foto-editor">
                <img id="preview-foto" src="<?= e($fotoPerfil ?? DEFAULT_AVATAR) ?>" alt="Foto de perfil actual">
                <div class="foto-editor-campos">
                    <div class="campo">
                        <label for="archivo">Subir imagen (JPG, PNG, WEBP o GIF · máx. 2 MB)</label>
                        <input type="file" id="archivo" name="archivo" accept="image/png,image/jpeg,image/webp,image/gif">
                    </div>
                    <div class="campo">
                        <label for="foto">O usar una URL</label>
                        <input type="url" id="foto" name="foto" placeholder="https://...">
                    </div>
                </div>
            </div>
            <div class="acciones-form">
                <button type="submit" class="btn"><i class="fas fa-save"></i> Guardar</button>
                <button type="submit" class="btn secundario" name="quitar" value="1"><i class="fas fa-rotate-left"></i> Restablecer</button>
            </div>
        </form>
        <script>
        document.getElementById('archivo').addEventListener('change', function () {
            if (this.files && this.files[0]) {
                document.getElementById('preview-foto').src = URL.createObjectURL(this.files[0]);
            }
        });
        </script>
        <?php else: ?>
        <p class="tabla-vacia">No se encontraron datos del usuario.</p>
        <?php endif; ?>
    </div>

    <div>
        <div class="panel">
            <h3><i class="fas fa-bolt"></i> Accesos rápidos</h3>
            <div class="accesos">
                <a href="<?= url('admin/inventario') ?>"><i class="fas fa-boxes-stacked"></i> Inventario</a>
                <a href="<?= url('admin/ventas') ?>"><i class="fas fa-cash-register"></i> Ventas</a>
                <a href="<?= url('admin/proveedores') ?>"><i class="fas fa-truck"></i> Proveedores</a>
                <a href="<?= url('admin/peticiones') ?>"><i class="fas fa-envelope"></i> Peticiones</a>
                <a href="<?= url('admin/reportes') ?>"><i class="fas fa-chart-column"></i> Reportes</a>
                <?php if ((int)($_SESSION['rol'] ?? 0) === 1): ?>
                <a href="<?= url('admin/usuarios') ?>"><i class="fas fa-users"></i> Usuarios</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="panel">
            <h3><i class="fas fa-clock-rotate-left"></i> Últimas ventas</h3>
            <div class="tabla-scroll">
                <table>
                    <thead>
                        <tr><th>ID</th><th>Producto</th><th>Cant.</th><th>Total</th></tr>
                    </thead>
                    <tbody>
                    <?php if (empty($recientes['ventas'])): ?>
                        <tr><td colspan="4" class="tabla-vacia">Sin ventas registradas.</td></tr>
                    <?php else: foreach (($recientes['ventas'] ?? []) as $v): ?>
                        <tr>
                            <td><?= e($v['idVenta']) ?></td>
                            <td><?= e($v['producto']) ?></td>
                            <td><?= e($v['cantidad']) ?></td>
                            <td>$ <?= money(((float)$v['precio_unitario']) * ((float)$v['cantidad'])) ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
