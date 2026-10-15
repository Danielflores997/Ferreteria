<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php');
    exit();
}

include "../compartido/conexion.php";

$correo = $_SESSION['correo'];

$stmt = $conn->prepare("SELECT fotoPerfil FROM usuario WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->bind_result($fotoPerfil);
$stmt->fetch();
$stmt->close();
$conn->close();

if (!$fotoPerfil) {
    $fotoPerfil = '../imagenes/default_avatar.jpg';
}


if (isset($_POST['idProveedor']) && !empty($_POST['idProveedor'])) {
    include "../compartido/conexion.php";

    $idProveedor = $_POST['idProveedor'];
    $query = "SELECT * FROM proveedor WHERE idProveedor = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idProveedor); // 'i' es para el tipo de dato entero
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($proveedor = $result->fetch_assoc()) {
        echo json_encode($proveedor);
    } else {
        echo json_encode(null);
    }
    
    $stmt->close();
    $conn->close();
    exit();
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
                url: '', // El formulario se envía al mismo archivo PHP.
                dataType: 'json',
                data: {'idProveedor': idProveedor},
                success: function(proveedor) {
                    if (proveedor) {
                        $('#nombreProveedor').val(proveedor.nombreProveedor);
                        $('#apellidoProveedor').val(proveedor.apellidoProveedor);
                        $('#telefonoProveedor').val(proveedor.telefonoProveedor);
                        $('#direccionProveedor').val(proveedor.direccionProveedor);
                        $('#correoProveedor').val(proveedor.correoProveedor);
                        // Agrega aquí más campos si es necesario.
                    } else {
                        alert('Proveedor no encontrado.');
                        // Opcional: limpiar los campos si el proveedor no se encuentra
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
                    <a class="btn-login" href="../compartido/cerrarSesion.php">Cerrar Sesión</a>
                </button>
            </div>
        </nav>
    </div>
    <div id="contenido">
        <div id="menu-lateral">
        <h3>
                <!-- Mostrar el rol del usuario -->
                <?php
                if (isset($_SESSION['rol'])) {
                    $rol = $_SESSION['rol'];
                    if ($rol == 1) {
                        echo "Administrador";
                    } elseif ($rol == 2) {
                        echo "Vendedor";
                    } else {
                        echo "Cliente";
                    }
                }
                ?>
            </h3>
            <div id="foto">
                <img src="<?php echo $fotoPerfil; ?>" alt="Foto de perfil">
            </div>
            <div class="nom-usuario">
                <?php
                if (isset($_SESSION['correo'])) {
                    echo "<h3>Bienvenido:<br>" . htmlspecialchars($_SESSION['correo']) . "</h3>"; // Añadí la función htmlspecialchars para evitar posibles problemas de seguridad al imprimir el correo.
                }
                ?>
            </div>
            <?php include "../compartido/menuLateral.php"; ?>
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
                        <label for="codigo">Ultimo Código</label>
                            <?php
                                include "../compartido/conexion.php";

                                $queryUltimoCodigo = "SELECT MAX(codigoProducto) AS ultimoCodigo FROM productos";
                                $resultUltimoCodigo = mysqli_query($conn, $queryUltimoCodigo);

                                if (!$resultUltimoCodigo) {
                                die("Error al obtener el último código del producto: " . mysqli_error($conn));
                                }

                                $rowUltimoCodigo = mysqli_fetch_assoc($resultUltimoCodigo);
                                $ultimoCodigoProducto = $rowUltimoCodigo['ultimoCodigo'];

                                echo '<input type="text" id="codigo" name="codigo"  required value="' . $ultimoCodigoProducto . '" readonly>';
                                ?>
                            </div>
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
    <script>
    function generarReporte() {
        window.location.href = "generar_reporte_inventario.php";
    }
    function generarReporteCsv() {
        window.location.href = "generar_reporte_inventario_csv.php";
    }
    </script>
    <script>
    $(document).ready(function() {
        // Realizar la petición AJAX para obtener los productos escasos
        $.ajax({
        type: 'GET',
        url: '../compartido/productosBajoStock.php',
        dataType: 'json',
        success: function(response) {
            // Verificar si hay productos escasos
            if (response.length > 0) {
                // Mostrar una alerta con los productos escasos
                mostrarAlertaEscasos(response);
            }
        }
    });
});

// Función para mostrar una alerta con los productos escasos
function mostrarAlertaEscasos(productos) {
    var mensaje = "Los siguientes productos tienen un stock menor de 10:\n";
    productos.forEach(function(producto) {
        mensaje += " - Código: " + producto.codigoProducto + " - " + producto.nombreProductos + "\n";
    });
    alert(mensaje);
}
</script>
            <?php
            include "../compartido/conexion.php";

            if (isset($_POST['guardar'])) {
                $idProducto = $_POST['id'];
                $codigoProducto = $_POST['codigo'];
                $nombreProducto = $_POST['nombre'];
                $valorProducto = $_POST['precio'];
                $stockProducto = $_POST['cantidad'];
                $descripcionProducto = $_POST['descripcion'];
                $nombreCategoria = $_POST['categoria'];

                $query = "UPDATE productos SET codigoProducto=?, nombreProductos=?, valorProducto=?, stockProducto=?, descripcionProducto=?, nombreCategoria=? WHERE idProducto=?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "ssdsssi", $codigoProducto, $nombreProducto, $valorProducto, $stockProducto, $descripcionProducto, $nombreCategoria, $idProducto);

                if (mysqli_stmt_execute($stmt)) {
                    echo "Cambios guardados correctamente.";
                } else {
                    echo "Error al guardar los cambios del producto: " . mysqli_error($conn);
                }

                mysqli_stmt_close($stmt);
            }

            if (isset($_POST['editar'])) {
                // Evita el uso de variables innecesarias y realiza la lógica necesaria para la edición.
                $idProducto = $_POST['id'];
                $query = "SELECT * FROM productos WHERE idProducto=?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $idProducto);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);

                mysqli_stmt_close($stmt);
            }
            ?>

            <?php
            include "../compartido/conexion.php";

            if (isset($_POST['guardar'])) {
                include "editar.php";
            } else {
                $query = "SELECT * FROM productos";
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    echo "Error al obtener los productos: " . mysqli_error($conn);
                }
            ?>
                <h4 id="titulo-tabla">INVENTARIO</h4>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <div id="buscar">
                    <button id="buscar-productos"><i class="fas fa-search"></i></button>
                    <input id="ip-buscar-productos" type="text">
                </div>
                <div id="tabla">
                    <table>
                        <tr>
                            <th class="celda-principal">Código</th>
                            <th class="celda-principal">Producto</th>
                            <th class="celda-principal">Precio</th>
                            <th class="celda-principal">Cantidad</th>
                            <th class="celda-principal">Descripción</th>
                            <th class="celda-principal">Categoría</th>
                            <th class="celda-principal">Acciones</th>
                        </tr>

                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['codigoProducto']); ?></td>
                                <td><?php echo htmlspecialchars($row['nombreProductos']); ?></td>
                                <td><?php echo htmlspecialchars($row['valorProducto']); ?></td>
                                <td><?php echo htmlspecialchars($row['stockProducto']); ?></td>
                                <td><?php echo htmlspecialchars($row['descripcionProducto']); ?></td>
                                <td><?php echo htmlspecialchars($row['nombreCategoria']); ?></td>
                                <td class="acciones">
                                    <form action="../compartido/editar.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['idProducto']); ?>">
                                        <button type="submit" name="editar"><i class="fas fa-edit"></i></button>
                                    </form>
                                    <form action="../compartido/eliminar.php" method="POST" onsubmit="return confirmarEliminacion();">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['idProducto']); ?>">
                                        <button type="submit" name="eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <script>
                    function confirmarEliminacion() {
                        return confirm("¿Estás seguro de que deseas eliminar este producto?");
                    }
                </script>
<script>
    $(document).ready(function() {
        // Agregar el evento de clic al botón de búsqueda de productos
        $("#buscar-productos").click(function() {
            // Obtener el valor del campo de búsqueda de productos
            var searchTerm = $("#ip-buscar-productos").val();

            // Realizar la petición AJAX al servidor para buscar productos
            $.ajax({
                url: "../compartido/buscarProducto.php", // Archivo PHP que manejará la búsqueda de productos
                method: "POST",
                data: { searchTerm: searchTerm }, // Enviar el término de búsqueda al servidor
                success: function(response) {
                    // Actualizar la tabla de productos con los resultados de la búsqueda
                    $("#tabla table").html(response);
                }
            });
        });
    });
</script>
            <?php
            }
            ?>
        </div>
    </div>
    <?php include "../compartido/footer.php"; ?>
</body>
</html>