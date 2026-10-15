<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php');
    exit();
}

// Incluir el archivo de conexión a la base de datos
include "../compartido/conexion.php";

// Obtener el correo del usuario de la sesión
$correo = $_SESSION['correo'];

// Realizar la consulta para obtener la información del usuario, incluyendo la foto de perfil
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

// Procesar el formulario para actualizar el estado de las compras
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el formulario se envió correctamente
    if (isset($_POST['estado']) && is_array($_POST['estado'])) {
        // Iterar sobre las compras y actualizar su estado en la base de datos
        foreach ($_POST['estado'] as $idCompra => $estado) {
            $stmt = $conn->prepare("UPDATE compras SET estado = ? WHERE id = ?");
            $stmt->bind_param("si", $estado, $idCompra);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Obtener el término de búsqueda
$terminoBusqueda = isset($_GET['buscar']) ? $_GET['buscar'] : '';

// Consulta SQL base
$sql = "SELECT c.id, u.nombresUsuario AS usuario, u.documentoUsuario AS numeroDocumento, p.nombreProductos AS producto, c.cantidad, c.fecha FROM compras c 
        JOIN usuario u ON c.usuario_id = u.idUsuario 
        JOIN productos p ON c.producto_id = p.idProducto
        WHERE u.nombresUsuario LIKE CONCAT('%', ?, '%') 
        OR u.documentoUsuario LIKE CONCAT('%', ?, '%')
        OR p.nombreProductos LIKE CONCAT('%', ?, '%')
        OR c.cantidad LIKE CONCAT('%', ?, '%')
        OR c.fecha LIKE CONCAT('%', ?, '%')";

// Preparar la consulta
$stmt = $conn->prepare($sql);

// Enlazar el término de búsqueda con la consulta preparada
$stmt->bind_param("sssss", $terminoBusqueda, $terminoBusqueda, $terminoBusqueda, $terminoBusqueda, $terminoBusqueda);

// Ejecutar la consulta
$stmt->execute();

// Obtener el resultado de la consulta
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/Peticiones.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Visualizar Compras</title>
</head>
<body>
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

    <div id="contenedor" style="display: flex;">
        <div id="menu-lateral">
            <h3>
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
                    echo "<h3>Bienvenido:<br> " . $_SESSION['correo'] . "</h3>";
                }
                ?>
            </div>
            <?php include "../compartido/menuLateral.php"; ?>
        </div>
        <!-- compras -->
        <div class="contenedor-tabla-peticiones">
            <h2 id="titulo-tabla">Compras Carrito</h2>
            <div id="buscar">
                <form method="GET" action="">
                    <button type="submit"><i class="fas fa-search"></i></button>
                    <input type="text" name="buscar" placeholder="Buscar compras">   
                </form>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Número de Documento</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                </tr>
                <?php
                // Mostrar los resultados de la consulta
                if ($resultado->num_rows > 0) {
                    $contadorFilas = 0;
                    while ($fila = $resultado->fetch_assoc()) {
                        $contadorFilas++;
                        echo "<tr class='filaCompra'>";
                        echo "<td>" . $fila['id'] . "</td>";
                        echo "<td>" . $fila['usuario'] . "</td>";
                        echo "<td>" . $fila['numeroDocumento'] . "</td>";
                        echo "<td>" . $fila['producto'] . "</td>";
                        echo "<td>" . $fila['cantidad'] . "</td>";
                        echo "<td>" . $fila['fecha'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay compras registradas.</td></tr>";
                }
                ?>
            </table>
            
            <!-- Marcador de página -->
            <div class="paginacion">
                <button onclick="irAPaginaAnterior()">Anterior</button>
                <span id="paginaActual">1</span>
                <button onclick="irASiguientePagina()">Siguiente</button>
            </div>
        </div>
    </div>
    <?php include "../compartido/footer.php"; ?>

    <script>
        var paginaActual = 1; // Página actual
        var totalFilas = <?php echo $contadorFilas; ?>; // Total de filas
        var filasPorPagina = 10; // Número de filas por página

        // Función para ir a la página anterior
        function irAPaginaAnterior() {
            if (paginaActual > 1) {
                paginaActual--;
                mostrarPagina();
            }
        }

        // Función para ir a la siguiente página
        function irASiguientePagina() {
            if (paginaActual < Math.ceil(totalFilas / filasPorPagina)) {
                paginaActual++;
                mostrarPagina();
            }
        }

        // Función para mostrar la página actual
        function mostrarPagina() {
            // Calcular el índice de inicio y fin de las filas a mostrar
            var inicio = (paginaActual - 1) * filasPorPagina;
            var fin = Math.min(inicio + filasPorPagina, totalFilas);

            // Ocultar todas las filas
            var filas = document.querySelectorAll(".filaCompra");
            for (var i = 0; i < filas.length; i++) {
                filas[i].style.display = "none";
            }

            // Mostrar las filas de la página actual
            for (var i = inicio; i < fin; i++) {
                filas[i].style.display = "table-row";
            }

            // Actualizar el número de página actual
            document.getElementById("paginaActual").textContent = paginaActual;
        }

        // Mostrar la primera página al cargar la página
        mostrarPagina();
    </script>
</body>
</html>
