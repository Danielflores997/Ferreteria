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
                        <button id="btn-venta" type="submit" name="guardar">
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
