<?php
session_start();
$fotoPerfil = '../imagenes/default_avatar.jpg';
if (isset($_SESSION['correo'])) {
    $conn = db();
    $stmt = $conn->prepare('SELECT fotoPerfil FROM usuario WHERE correo = ?');
    $stmt->bind_param('s', $_SESSION['correo']);
    $stmt->execute();
    $stmt->bind_result($fotoPerfilDb);
    if ($stmt->fetch()) {
        $fotoPerfil = $fotoPerfilDb ?: '../imagenes/default_avatar.jpg';
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/Inventario.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Inventario</title>
</head>
<body>
<script>
$(document).ready(function() {
    $('#idProveedor').on('change', function() {
        var idProveedor = $(this).val().trim();
        if (idProveedor.length > 0) {
            $.ajax({
                type: 'POST',
                url: '',
                dataType: 'json',
                data: {'idProveedor': idProveedor},
                success: function(proveedor) {
                    if (proveedor) {
                        $('#nombreProveedor').val(proveedor.nombreProveedor);
                        $('#apellidoProveedor').val(proveedor.apellidoProveedor);
                        $('#telefonoProveedor').val(proveedor.telefonoProveedor);
                        $('#direccionProveedor').val(proveedor.direccionProveedor);
                        $('#correoProveedor').val(proveedor.correoProveedor);
                    } else {
                        alert('Proveedor no encontrado.');
                    }
                }
            });
        }
    });
});
</script>

<div class="encabezado">
    <header>
        <div class="titulo">
            <h1>FERRETERIA MEISSEN</h1>
        </div>
        <div class="logo">
            <img src="../imagenes/ferreteria.jpeg" alt="logo ferreteria">
        </div>
    </header>
    <nav class="navbar">
        <div class="lista">
            <button class="btn-login">
                <a class="btn-login" href="../public/logout.php">Cerrar Sesión</a>
            </button>
        </div>
    </nav>
</div>

<div id="contenido">
    <div id="menu-lateral">
        <h3>
            <?php
            if (isset($_SESSION['rol'])) {
                $rol = $_SESSION['rol'];
                if ($rol == 1) {
                    echo 'Administrador';
                } elseif ($rol == 2) {
                    echo 'Vendedor';
                } else {
                    echo 'Cliente';
                }
            }
            ?>
        </h3>
        <div id="foto">
            <img src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de perfil">
        </div>
        <div class="nom-usuario">
            <?php if (isset($_SESSION['correo'])): ?>
                <h3>Bienvenido:<br><?php echo htmlspecialchars($_SESSION['correo']); ?></h3>
            <?php endif; ?>
        </div>
        <?php include __DIR__ . '/../../../compartido/menuLateral.php'; ?>
    </div>

    <div class="inventario">
        <h4 id="titulo-tabla">Datos Proveedor</h4>
        <div id="conten-venta">
            <form id="formulario-venta" action="../compartido/agregarProducto.php" method="POST">
                <div class="datos-proveedor">
                    <label for="nombreProveedor">Documento Proveedor</label>
                    <input type="text" id="idProveedor" name="idProveedor" placeholder="Documento Proveedor" required>

                    <label for="nombreProveedor">Nombre Proveedor</label>
                    <input type="text" id="nombreProveedor" name="nombreProveedor" placeholder="Nombre Proveedor" required>

                    <label for="apellidoProveedor">Apellido Proveedor</label>
                    <input type="text" id="apellidoProveedor" name="apellidoProveedor" placeholder="Apellido Proveedor" required>

                    <label for="telefonoProveedor">Teléfono</label>
                    <input type="text" id="telefonoProveedor" name="telefonoProveedor" placeholder="Telefono" required>

                    <label for="direccionProveedor">Dirección</label>
                    <input type="text" id="direccionProveedor" name="direccionProveedor" placeholder="Dirección" required>

                    <label for="correoProveedor">Correo</label>
                    <input type="text" id="correoProveedor" name="correoProveedor" placeholder="Correo" required>
                </div>

                <h4 id="titulo-tabla">Agregar Productos</h4>
                <div id="contenidoDos">
                    <div id="contenidoUno">
                        <div class="input-izquierda">
                            <label for="codigo">Código</label>
                            <input type="text" id="codigo" name="codigo" placeholder="Código" required>
                        </div>
                        <div class="input-derecha">
                            <label for="producto">Producto</label>
                            <input type="text" id="producto" name="producto" placeholder="Producto" required>
                        </div>
                        <div class="input-izquierda">
                            <label for="precio">Precio UNI</label>
                            <input type="text" id="precio" name="precio" placeholder="Precio UNI" required>
                        </div>
                        <div class="input-derecha">
                            <label for="cantidad">Cantidad</label>
                            <input type="text" id="cantidad" name="cantidad" placeholder="Cantidad" required>
                        </div>
                    </div>
                    <div id="contenidoUno">
                        <div class="input-derecha">
                            <label for="descripcion">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" placeholder="Descripción" required>
                        </div>
                        <div class="input-izquierda">
                            <label for="categoria">Categoría</label>
                            <select name="categoria" id="select-categoria" required>
                                <option selected="selected" value="1">Herramientas</option>
                                <option value="2">Pinturas</option>
                                <option value="3">Cementos</option>
                                <option value="4">Herramientas Electricas</option>
                                <option value="5">Carpintería</option>
                                <option value="6">Tornillería</option>
                                <option value="7">Plomería</option>
                                <option value="8">Jardinería</option>
                                <option value="9">Accesorios</option>
                            </select>
                        </div>
                        <div class="input-derecha">
                            <label for="imagen">Imagen</label>
                            <input type="text" id="imagen" name="imagen" placeholder="Ruta Imagen">
                        </div>
                    </div>
                </div>

                <div id="conten-botones">
                    <button id="btn-venta" type="submit" name="guardar">
                        <i class="fas fa-save"></i><i class="fas fa-arrow-circle-right"></i> Guardar
                    </button>
                    <button id="btn-generar" type="button" onclick="generarReporte()">
                        <i class="fas fa-file-alt"></i> Generar Reporte
                    </button>
                    <button id="btn-generar" type="button" onclick="generarReporteCsv()">
                        <i class="fas fa-file-alt"></i> Generar Reporte excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function generarReporte() {
    window.location.href = "../public/reportes.php";
}
function generarReporteCsv() {
    window.location.href = "../public/reportes.php";
}
</script>
</body>
</html>
