<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php'); // Redirigir si el usuario no ha iniciado sesión
    exit();
}
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
    <div id="contenido">
        <div id="menu-lateral">
            <h3>Administrador</h3>
            <div id="foto">
                <img src="../imagenes/administrador ferreteria.jpg" alt="">
            </div>
            <div class="nom-usuario">
                <!-- Aquí puedes mostrar el correo del usuario -->
                <?php
                if (isset($_SESSION['correo'])) {
                    echo "<h3>Bienvenido: " . $_SESSION['correo'] . "</h3>";
                }
                ?>
            </div>
            <select id="selec-admin" onchange="location.href=this.value;">
                <option selected>Opciones</option>
                <option value="vistaAdmin.php">Inicio</option>
                <option value="inventario.php">Gestión Catalogo e Inventario</option>
                <option value="catalogoAdmin.php">Vista catalogo</option>
                <option value="gestionarFuncionarios.php">Gestionar Usuarios</option>
                <option value="ventas.php">Ventas</option>
                <option value="peticiones.php">peticiones</option>
            </select>
        </div>
        <div class="inventario">
            <h4 id="titulo-tabla">Agregar Productos</h4>
            <div id="conten-venta">
                <form id="formulario-venta" action="../compartido/agregarProducto.php" method="POST">
                    <div id="contenidoDos">
                    <div id="contenidoUno">
                        <div class="input-izquierda">
                            <label for="codigo">Código</label>
                            <input type="text" id="codigo" placeholder="Código" name="codigo">
                        </div>
                        <div class="input-derecha">
                            <label for="producto">Producto</label>
                            <input type="text" id="producto" placeholder="Producto" name="producto">
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
                    <div id="contenidoUno">
                        <div class="input-derecha">
                            <label for="descripcion">Descripción</label>
                            <input type="text" id="descripcion" placeholder="Descripción" name="descripcion">
                        </div>
                        <div class="input-izquierda">
                            <label for="categoria">Categoria</label>
                            <select name="categoria" id="select-categoria">
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
                </div>
            </form>
            </div>

            <?php
            include "../compartido/conexion.php";

            if (isset($_POST['guardar'])) {
                $idProducto = $_POST['id'];
                $codigoProducto = $_POST['codigo'];
                $nombreProducto = $_POST['nombre'];
                $valorProducto = $_POST['valor'];
                $stockProducto = $_POST['stock'];
                $descripcionProducto = $_POST['descripcion'];
                $nombreCategoria = $_POST['categoria'];

                // Aquí puedes agregar la lógica para guardar los cambios del producto
                $query = "UPDATE productos SET codigoProducto='$codigoProducto', nombreProductos='$nombreProducto', valorProducto=$valorProducto, stockProducto=$stockProducto, descripcionProducto='$descripcionProducto', nombreCategoria='$nombreCategoria' WHERE idProducto=$idProducto";

                $result = mysqli_query($conn, $query);
                if (!$result) {
                    echo "Error al guardar los cambios del producto: " . mysqli_error($conn);
                }
            }

            if (isset($_POST['editar'])) {
                $idProducto = $_POST['id'];

                // Aquí puedes agregar la lógica para recuperar los datos del producto
                // correspondiente al ID proporcionado y cargarlos en un formulario de edición
                $query = "SELECT * FROM productos WHERE idProducto=$idProducto";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);

                // Variables para almacenar los valores actuales del producto
                $codigoProducto = $row['codigoProducto'];
                $nombreProducto = $row['nombreProductos'];
                $valorProducto = $row['valorProducto'];
                $stockProducto = $row['stockProducto'];
                $descripcionProducto = $row['descripcionProducto'];
                $nombreCategoria = $row['nombreCategoria'];
            }
            ?>

            <?php
            include "../compartido/conexion.php";

            if (isset($_POST['guardar'])) {
                include "editar.php";
            } else {
                // Realizar la consulta a la base de datos
                $query = "SELECT * FROM productos";
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    echo "Error al obtener los productos: " . mysqli_error($conn);
                }
            ?>
                <h4 id="titulo-tabla">INVENTARIO</h4>
                <div id="tabla">
                    <table>
                        <tr>
                            <th id="celda-principal">Código</th>
                            <th id="celda-principal">Producto</th>
                            <th id="celda-principal">Precio</th>
                            <th id="celda-principal">Cantidad</th>
                            <th id="celda-principal">Descripción</th>
                            <th id="celda-principal">Categoría</th>
                            <th id="celda-principal">Acciones</th>
                        </tr>

                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $row['codigoProducto']; ?></td>
                                <td><?php echo $row['nombreProductos']; ?></td>
                                <td><?php echo $row['valorProducto']; ?></td>
                                <td><?php echo $row['stockProducto']; ?></td>
                                <td><?php echo $row['descripcionProducto']; ?></td>
                                <td><?php echo $row['nombreCategoria']; ?></td>
                                <td class="acciones">
                                    <form action="../compartido/editar.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['idProducto']; ?>">
                                        <button type="submit" name="editar"><i class="fas fa-edit"></i></button>
                                    </form>
                                    <form action="../compartido/eliminar.php" method="POST" onsubmit="return confirmarEliminacion();">
                                        <input type="hidden" name="id" value="<?php echo $row['idProducto']; ?>">
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

            <?php
            }
            ?>
        </div>
    </div>
    <?php include "../compartido/footer.php"; ?>
</body>

</html>

