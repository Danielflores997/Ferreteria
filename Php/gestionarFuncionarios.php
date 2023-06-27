<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/gestionarFuncionarios.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Funcionarios</title>
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
                <a href="index.php" class="CatalogoTodo">Catalogo</a>
                <a href="#" class="Pintura">Pintura</a>
                <a href="inventario.php" class="Electricas">Electricas</a>
                <a href="#" class="Herramientas_Manuales">Herramientas Manuales</a>
                <a href="#" class="Accesorios">Accesorios</a>
                <button class="btn-login">
                    <a class="btn-login" href="loginCliente.php">Acceder</a>
                </button>
                <button class="btn-login">
                    <a class="btn-login" href="registroCliente.php">Regístrate</a>
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
            <option value="index.php">Inicio</option>
            <option value="inventario.php">Gestión Catalogo e Inventario</option>
            <option value="gestionarFuncionarios.php">Gestionar Usuarios</option>
            <option value="ventas.php">Ventas</option>
            </select>
 
        </div>

        <div class="inventario">
        <h4 id="titulo-tabla">Usuarios</h4>
<div id="buscar">
    <button><i class="fa-solid fa-magnifying-glass"></i></button>
    <input id="ip-buscar" type="text">
</div>
<div id="tabla">
    <table>
        <tr>
            <th id="celda-principal">Tipo Documento</th>
            <th id="celda-principal">Identificación</th>
            <th id="celda-principal">Nombre</th>
            <th id="celda-principal">Apellido</th>
            <th id="celda-principal">Correo</th>
            <th id="celda-principal">Rol</th>
            <th id="celda-principal">Acciones</th>
        </tr>
        <?php
        include "../compartido/conexion.php";

        // Realizar la consulta a la base de datos
        $query = "SELECT * FROM usuario";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "Error al obtener los usuarios: " . mysqli_error($conn);
        }

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['tipoDocumentoUsuario']; ?></td>
                <td><?php echo $row['documentopUsuario']; ?></td>
                <td><?php echo $row['nombresUsuario']; ?></td>
                <td><?php echo $row['apellidosUsuario']; ?></td>
                <td><?php echo $row['correo']; ?></td>
                <td><?php echo $row['rol_idRol']; ?></td>
                <td class="acciones">
                    <button><i class="fas fa-edit"></i></button>
                    <button><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>

<div class="inventario">
    <h4 id="titulo-tabla">clientes</h4>
    <div id="buscar">
        <button><i class="fa-solid fa-magnifying-glass"></i></button>
        <input id="ip-buscar" type="text">
    </div>
    <div id="tabla">
    <table>
        <tr>
            <th id="celda-principal">Tipo Documento</th>
            <th id="celda-principal">Identificación</th>
            <th id="celda-principal">Nombre</th>
            <th id="celda-principal">Apellido</th>
            <th id="celda-principal">Telefono</th>
            <th id="celda-principal">Direccion</th>
            <th id="celda-principal">Correo</th>
            <th id="celda-principal">Acciones</th>
        </tr>
        <?php
        include "../compartido/conexion.php";

        // Realizar la consulta a la base de datos
        $query = "SELECT * FROM cliente";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "Error al obtener los clientes : " . mysqli_error($conn);
        }

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['tipoDocumentoCliente']; ?></td>
                <td><?php echo $row['documentoCliente']; ?></td>
                <td><?php echo $row['nombresCliente']; ?></td>
                <td><?php echo $row['apellidosCliente']; ?></td>
                <td><?php echo $row['telefonoCliente']; ?></td>
                <td><?php echo $row['direccionCliente']; ?></td>
                <td><?php echo $row['estadoCliente']; ?></td>
                <td class="acciones">
                    <button><i class="fas fa-edit"></i></button>
                    <button><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Agregar el evento de clic al botón de búsqueda
            $("#buscar button").click(function() {
                // Obtener el valor del campo de búsqueda
                var searchTerm = $("#ip-buscar").val();

                // Realizar la petición AJAX al servidor
                $.ajax({
                    url: "../compartido/buscar.php", // Archivo PHP que manejará la búsqueda
                    method: "POST",
                    data: { searchTerm: searchTerm }, // Enviar el término de búsqueda al servidor
                    success: function(response) {
                        // Actualizar la tabla con los resultados de la búsqueda
                        $("#tabla table").html(response);
                    }
                });
            });
        });
    </script>
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