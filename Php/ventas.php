<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php');
    exit();
}

// Incluir el archivo de conexión a la base de datos
include "../compartido/conexion.php";

// Verificar si se está realizando una solicitud AJAX para buscar los datos del cliente
if (isset($_POST['documentoCliente']) && !empty($_POST['documentoCliente'])) {
    $documentoCliente = $_POST['documentoCliente'];

    $stmt = $conn->prepare("SELECT documentoCliente, nombresCliente, apellidosCliente, telefonoCliente, direccionCliente, estadoCliente FROM cliente WHERE documentoCliente = ?");
    $stmt->bind_param("s", $documentoCliente);
    $stmt->execute();
    $result = $stmt->get_result();
    $cliente = $result->fetch_assoc();
    $stmt->close();

    echo json_encode($cliente); // Devuelve el resultado en formato JSON
    $conn->close();
    exit(); // Detiene la ejecución del script para no cargar el resto de la página
}

if (isset($_POST['codigoProducto']) && !empty($_POST['codigoProducto'])) {
    $codigoProducto = $_POST['codigoProducto'];

    $stmt = $conn->prepare("SELECT codigoProducto, nombreProductos, descripcionProducto, valorProducto, nombreCategoria FROM productos WHERE codigoProducto = ?");
    $stmt->bind_param("s", $codigoProducto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
    $stmt->close();

    echo json_encode($producto);
    $conn->close();
    exit();
}


// Realizar la consulta para obtener la información del usuario, incluyendo la foto de perfil
$correo = $_SESSION['correo'];

$stmt = $conn->prepare("SELECT fotoPerfil FROM usuario WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->bind_result($fotoPerfil);
$stmt->fetch();
$stmt->close();

// Si no se encontró la foto de perfil, utilizar una por defecto
if (!$fotoPerfil) {
    $fotoPerfil = '../imagenes/default_avatar.png';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/Inventario.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Inventario</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
<script>
    // Script de AJAX
    $(document).ready(function() {
        $('#documentoCliente').on('change', function() {
            var documentoCliente = $(this).val();
            $.ajax({
                type: 'POST',
                url: '', // La solicitud se maneja en el mismo archivo, por eso la URL está vacía
                data: {'documentoCliente': documentoCliente},
                success: function(data) {
                    var resultado = JSON.parse(data);
                    if (resultado) {
                        // Rellenar los campos del formulario
                        $('#nombresCliente').val(resultado.nombresCliente);
                        $('#apellidosCliente').val(resultado.apellidosCliente);
                        $('#telefonoCliente').val(resultado.telefonoCliente);
                        $('#direccionCliente').val(resultado.direccionCliente);
                        $("#select-Estado").val(resultado.estadoCliente);
                    } else {
                        // Opcional: Limpiar los campos o mostrar un mensaje si no se encuentra el cliente
                    }
                }
            });
        });
    // Nuevo AJAX para buscar datos del producto
    $('#id').on('change', function() {
            var codigoProducto = $(this).val();
            $.ajax({
                type: 'POST',
                url: '', // La solicitud se maneja en el mismo archivo
                data: {'codigoProducto': codigoProducto},
                success: function(data) {
                    var resultado = JSON.parse(data);
                    if (resultado) {
                        $('#producto').val(resultado.nombreProductos);
                        $('#descripcion').val(resultado.descripcionProducto);
                        $('#Precio').val(resultado.valorProducto);
                        // Asumiendo que el select de categoría puede ser seleccionado por el nombre de la categoría.
                        // Esto requeriría ajustar los valores de las opciones para que coincidan con los nombres de las categorías en lugar de los IDs.
                        $("#select-Categoria option").filter(function() {
                            return $(this).text() == resultado.nombreCategoria; 
                        }).prop('selected', true);
                    } else {
                        // Opcional: Limpiar los campos o mostrar un mensaje si no se encuentra el producto
                        $('#producto').val('');
                        $('#descripcion').val('');
                        $('#Precio').val('');
                        $("#select-Categoria").val($("#select-Categoria option:first").val());
                    }
                }
            });
        });

        $('#btn-guardar').on('click', function() {
            var datosFormulario = {
            'guardar': '1', // Este campo es crucial para que el servidor procese la solicitud correctamente.
            'id': $('#id').val(),
            'producto': $('#producto').val(),
            'precio': $('#Precio').val(),
            'cantidad': $('#cantidad').val(),
            'descripcion': $('#descripcion').val(),
            'categoria': $('#select-Categoria').val(),
            // Asegúrate de incluir aquí todos los campos necesarios del formulario.
            'tipoDocumentoCliente': $('#select-TipoDocumentoCliente').val(),
            'documentoCliente': $('#documentoCliente').val(),
            'nombresCliente': $('#nombresCliente').val(),
            'apellidosCliente': $('#apellidosCliente').val(),
            'telefonoCliente': $('#telefonoCliente').val(),
            'direccionCliente': $('#direccionCliente').val(),
            'estadoCliente': $('#select-Estado').val(),
        };

    $.ajax({
        type: 'POST',
        url: '../compartido/agregarVenta.php', // Asegúrate de que esta URL es correcta
        data: datosFormulario,
        success: function(response) {
        const resultado = JSON.parse(response);
            alert(resultado.message);
            if (resultado.success) {
                window.location.reload(); // O cualquier otra lógica que necesites ejecutar
            }
        },
        error: function() {
            alert('Error al guardar la venta');
        }
    });
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
            <h3>Administrador</h3>
            <div id="foto">
                <img src="<?php echo $fotoPerfil; ?>" alt="Foto de perfil">
            </div>
            <div class="nom-usuario">
                <!-- Aquí puedes mostrar el correo del usuario -->
                <?php
                if (isset($_SESSION['correo'])) {
                    echo "<h3>Bienvenido: " . $_SESSION['correo'] . "</h3>";
                }
                ?>
            </div>
            <?php include "../compartido/menuLateral.php"; ?>
        </div>
        <div class="inventario">
            <h4 id="titulo-tabla">Documento Venta</h4>  
            <div id="conten-venta">
                <form id="formulario-venta" action="../compartido/agregarVenta.php" method="POST">
                    <div class="datos-proveedor">
                        <label for="documentoCliente">Tipo de Documento</label>
                        <select name="tipoDocumentoCliente" id="select-TipoDocumentoCliente">
                            <option value="CC">CC</option>
                            <option value="TI">TI</option>
                            <option value="CE">CE</option>
                        </select>

                        <input type="text" id="documentoCliente" placeholder="Documento Cliente" name="documentoCliente">
                        <input type="text" id="nombresCliente" placeholder="Nombres Cliente" name="nombresCliente">
                        <input type="text" id="apellidosCliente" placeholder="Apellidos Cliente" name="apellidosCliente">
                        <input type="text" id="telefonoCliente" placeholder="Telefono Cliente" name="telefonoCliente">
                        <input type="text" id="direccionCliente" placeholder="Direccion Cliente" name="direccionCliente">
                        <select name="estadoCliente" id="select-Estado">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                    <h4 id="titulo-tabla">Agregar Productos</h4>
                    <div id="contenidoDos">
                        <div id="contenidoUno">
                            <div class="input-izquierda">
                                <label for="codigo">Código</label>
                                <input type="text" id="id" name="id" placeholder="Código">
                            </div>
                            <div class="input-derecha">
                                <label for="producto">Producto</label>
                                <input type="text" id="producto" placeholder="Producto" name="producto">
                            </div>
                            <div class="input-derecha">
                                <label for="descripcion">Descripción</label>
                                <input type="text" id="descripcion" placeholder="Descripción" name="descripcion">
                            </div>
                            <div class="input-izquierda">
                                <label for="Categoria">Categoria</label>
                                <select name="categoria" id="select-Categoria">
                                    <option selected="selected" value="1">Herramientas</option>
                                    <option value="2">Pinturas</option>
                                    <option value="3">Cementos</option>
                                    <option value="4">Herramientas Electricas</option>
                                    <option value="5">Carpinteria</option>
                                    <option value="6">Tornilleria</option>
                                    <option value="7">Plomeria</option>
                                    <option value="8">Jardineria</option>
                                    <option value="9">Accesorios</option>
                                </select>
                            </div>
                            <div class="input-izquierda">
                                <label for="descuento">Precio UNI</label>
                                <input type="text" id="Precio" placeholder="Precio UNI" name="precio">
                            </div>
                            <div class="input-derecha">
                                <label for="cantidad">Cantidad</label>
                                <input type="text" id="cantidad" placeholder="Cantidad" name="cantidad">
                            </div>
                        </div>
                    </div>
                    <div id="conten-botones">
                        <button id="btn-guardar" type="button" name="guardar">
                            <i class="fas fa-save"></i><i class="fas fa-arrow-circle-right"></i> Guardar
                        </button>
                        <button id="btn-generar-reporte" type="submit" formaction="generar_reporte_ventas.php" formtarget="_blank">
                            Generar Reporte pdf
                        </button>
                        <button id="btn-generar-reporte-csv" type="submit" formaction="generar_reporte_ventas_csv.php" formtarget="_blank">
                            Generar Reporte excel
                        </button>
                    </div>
                </form>
            </div>
            <?php include "../compartido/generarVenta.php"; ?>
        </div>
    </div>
    <?php include "../compartido/footer.php"; ?>
</body>
</html>
