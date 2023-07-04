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
    <div class="encabezado">
        <header>
            <div class = titulo>
            <h1>FERRETERIA MEISSEN</h1>
            </div>    
            <div class="logo" >
            <img src="../imagenes/ferreteria.jpeg" alt="logo ferreteria">
            </div>
        </header>
        <nav class="navbar">
            <div class="lista">
            <button class="btn-login">
            <a class="btn-login"href="index.php">Cerrar Sesión</a>
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
            <h3>Nombre Usuario</h3>
            </div>
                <select id="selec-admin" onchange="location.href=this.value;">
                <option selected>Opciones</option>
                <option value="vistaCatalogo.php">Inicio</option>
                <option value="inventario.php">Gestión Catalogo e Inventario</option>
                <option value="gestionarFuncionarios.php">Gestionar Usuarios</option>
                <option value="ventas.php">Ventas</option>
                </select>
            </div>
        <div class="inventario">
            <h4 id="titulo-tabla">Agregar Productos</h4>            
            <div id="buscar">
                <div id="conten-venta">
                <form id="formulario-venta" action="../compartido/agregarProducto.php" method="POST">
                    <div class="input-derecha">
                        <label for="codigo">Código</label>
                        <input type="text" id="codigo" placeholder="Código" name="codigo">
                    </div>
                    
                    <div class="input-izquierda">
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
                    <div class="input-derecha">
                        <label for="descripcion">Descripción</label>
                        <input type="text" id="descripcion" placeholder="descripcion"  name="descripcion">
                    </div>
                    <div class="input-derecha">
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
                        <option value="9">Proteccion</option>
                    </select>
                </div>
            </div>
                <div id="conten-botones">
                    <button id="btn-venta"><i class="far fa-save"></i><i class="fas fa-times-circle"></i> Cancelar</button>
                    <button id="btn-venta" type="submit" name="guardar">
                                <i class="fas fa-save"></i><i class="fas fa-arrow-circle-right"></i> Guardar
                            </button>
                </div>
                </div>
                </form>
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
        include "../compartido/conexion.php";
        if (isset($_POST['guardar'])) {
            include "../compartido/agregarProducto.php";
        }
        
        // Realizar la consulta a la base de datos
        $query = "SELECT * FROM productos";
        $result = mysqli_query($conn, $query); // Cambio de $conexion a $conn

        if (!$result) {
            echo "Error al obtener los productos: " . mysqli_error($conn); // Cambio de $conexion a $conn
        }

        ?>

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
    <button name="editar"><i class="fas fa-edit"></i></button>
    <form action="../compartido/eliminar.php" method="POST">
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
    </div>
        </div>
            </div>
        <footer>
            <h4>Ferreteria Meissen</h4>
            <div class="enlaces">
                <ul>
                    <li><a href="index.html">Catalogo</a></li>
                    <li><a href="#">Pintura</a></li>
                    <li><a href="elctricas.html">Electricas</a></li>
                    <li><a href="#">Herramientas Manuales</a></li>
                    <li><a href="#">Accesorios</a></li>
                </ul>
            </div>
            <h4>Redes sociales</h4>
            <div class="sociales">
            <div class="sociales-link">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-whatsapp"></i></a>
            </div>
            </div>
        </footer>
    </body>
</html>