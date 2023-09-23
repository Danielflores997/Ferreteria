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
    <link rel="stylesheet" type="text/css" href="../CSS/ventas.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Ventas</title>
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
                <?php
                if (isset($_SESSION['correo'])) {
                    echo "<h3>Bienvenido: " . $_SESSION['correo'] . "</h3>";
                }
                ?>
            </div>
            <select id="selec-admin" onchange="location.href=this.value;">
                <option selected>Opciones</option>
                <option value="vistaAdmin.php">Inicio</option>
                <option value="inventario.php">Gestión Catálogo e Inventario</option>
                <option value="gestionarFuncionarios.php">Gestionar Usuarios</option>
                <option value="ventas.php">Ventas</option>
                <option value="peticiones.php">peticiones</option>
            </select>
        </div>
        <div class="inventario">
            <h4 id="titulo-tabla">Documento de Venta</h4>
            <div id="conten-venta">
                <form id="formulario-venta" action="../compartido/agregarVenta.php" method="POST">
                    <div id="contenidoUno">


                        <div class="input-derecha">
                            <label for="codigo">Código</label>
                            <input type="text" id="id" name="id" placeholder="Código">
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
                    </div>
                    <div id="contenidoUno">
                        <div class="input-derecha">
                            <label for="producto">Producto</label>
                            <input type="text" id="producto" name="producto" placeholder="Producto">
                        </div>
                        <div class="input-izquierda">
                            <label for="descuento">Precio UNI</label>
                            <input type="text" id="precio" name="precio" placeholder="Precio UNI">
                        </div>
                        <div class="input-derecha">
                            <label for="cantidad">Cantidad</label>
                            <input type="text" id="cantidad" name="cantidad" placeholder="Cantidad">
                        </div>
                        <div class="input-izquierda">
                            <label for="imagen">Imagen</label>
                            <input id="text" id="imagen" name="imagen" placeholder="Ruta Imagen">
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

            $queryCategorias = "SELECT * FROM categoria";
            $resultCategorias = mysqli_query($conn, $queryCategorias);
            if (!$resultCategorias) {
                echo "Error al obtener las categorías: " . mysqli_error($conn);
            }

            $categorias = array();
            while ($rowCategoria = mysqli_fetch_assoc($resultCategorias)) {
                $categorias[$rowCategoria['idCategoria']] = $rowCategoria['nombreCategoria'];
            }
            if (isset($_POST['guardar'])) {
                $idcodigo = $_POST['id'];
                $producto = $_POST['producto'];
                $precio_unitario = $_POST['precio'];
                $cantidad = $_POST['cantidad'];
                $descripcion = $_POST['descripcion'];
                $categoria = $_POST['categoria'];

                $query = "UPDATE ventas SET producto='$producto', precio_unitario='$precio_unitario', cantidad=$cantidad, descripcion=$descripcion, Categoria='$categoria' WHERE idcodigo=$idcodigo";

                $result = mysqli_query($conn, $query);
                if (!$result) {
                    echo "Error al guardar los cambios del producto: " . mysqli_error($conn);
                }
            }

            if (isset($_POST['editar'])) {
                $idProducto = $_POST['id'];

                $query = "SELECT * FROM ventas WHERE idcodigo=$idcodigo";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);

                $producto = $row['producto'];
                $precio_unitario = $row['precio'];
                $cantidad = $row['cantidad'];
                $descripcion = $row['descripcion'];
                $categoria = $row['categoria'];
            }
            ?>
            <?php
            include "../compartido/conexion.php";

            if (isset($_POST['guardar'])) {
                include "editarVenta.php";
            } else {
                
                $query = "SELECT * FROM Ventas";
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    echo "Error al obtener los productos: " . mysqli_error($conn);
                }
            ?>
                <h4 id="titulo-tabla">Ventas</h4>
                <div id="tabla">
                    <table>
                        <tr>
                            <th id="celda-principal">id</th>
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
                                <td><?php echo $row['idcodigo']; ?></td>
                                <td><?php echo $row['producto']; ?></td>
                                <td><?php echo $row['precio_unitario']; ?></td>
                                <td><?php echo $row['cantidad']; ?></td>
                                <td><?php echo $row['descripcion']; ?></td>
                                <td>
                                    <?php foreach ($categorias as $idCategoria => $nombreCategoria) { ?>
                                        <?php if ($idCategoria == $row['Categoria']) echo $nombreCategoria ?>
                                    <?php } ?>
                                </td>
                                <td class="acciones">
                                    <form action="../compartido/editarVenta.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['idcodigo']; ?>">
                                        <button type="submit" name="editar"><i class="fas fa-edit"></i></button>
                                    </form>
                                    <form action="../compartido/eliminarVenta.php" method="POST" onsubmit="return confirmarEliminacion();">
                                        <input type="hidden" name="id" value="<?php echo $row['idcodigo']; ?>">
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