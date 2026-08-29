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
<div id="contenedor" style="display:flex">
<?php require APP_PATH . '/views/partials/menu_lateral.php'; ?>
<div class="inventario" style="flex:1;padding:1rem">
<h4>Editar Usuario</h4>
<?php if (!empty($error)): ?><p style="color:red"><?= e($error) ?></p><?php endif; ?>
<form action="<?= url('admin/editarUsuario/'.(int)$usuario['idUsuario']) ?>" method="POST">
<input type="hidden" name="id" value="<?= (int)$usuario['idUsuario'] ?>">
<label>Tipo Documento</label><input name="tipoDocumento" value="<?= e($usuario['tipoDocumentoUsuario']) ?>">
<label>Identificación</label><input name="identificacion" value="<?= e($usuario['documentoUsuario']) ?>">
<label>Nombre</label><input name="nombre" value="<?= e($usuario['nombresUsuario']) ?>">
<label>Apellido</label><input name="apellido" value="<?= e($usuario['apellidosUsuario']) ?>">
<label>Correo</label><input name="correo" value="<?= e($usuario['correo']) ?>">
<label>Nueva Contraseña</label><input name="nuevaContraseña" value="">
<label>Rol (1=Admin,2=Vendedor,3=Cliente)</label><input name="rol" value="<?= e($usuario['rol_idRol']) ?>">
<label>Estado</label>
<select name="estado">
<option value="Activo" <?= $usuario['estadoUsuario']==='Activo'?'selected':'' ?>>Activo</option>
<option value="Inactivo" <?= $usuario['estadoUsuario']==='Inactivo'?'selected':'' ?>>Inactivo</option>
</select>
<button type="submit" name="guardar">Guardar Cambios</button>
</form>
</div></div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
