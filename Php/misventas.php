<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/carrito.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Mis Ventas</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php include "../compartido/menu.php"; ?>

        </header>
        <nav class="navbar">
            <div class="lista">
                <button class="btn-login">
                    <a class="btn-login" href="../compartido/cerrarSesion.php">Cerrar Sesión</a>
                </button>
            </div>
        </nav>
    </div>
    <div id="contenedor">
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
                <option value="inventario.php">Gestión Catálogo e Inventario</option>
                <option value="catalogoAdmin.php">Vista catalogo</option>
                <option value="gestionarFuncionarios.php">Gestionar Usuarios</option>
                <option value="ventas.php">Ventas</option>
                <option value="peticiones.php">peticiones</option>
                <option value="carrito.php">carrito</option>
            </select>
        </div>
    <div class="container">
        <h2>verificacion de ventas</h2>
        <form action="procesar_compra.php" method="post">
            <label for="idFactura">ID de Factura:</label>
            <input type="text" id="idFactura" name="idFactura" required>

            <label for="fechaFactura">Fecha de Factura:</label>
            <input type="date" id="fechaFactura" name="fechaFactura" required>

            <label for="subtotalfactura">Subtotal:</label>
            <input type="number" id="subtotalfactura" name="subtotalfactura" required>

            <label for="impuesto">Impuesto:</label>
            <input type="number" id="impuesto" name="impuesto" required>

            <label for="valorTotalFactura">Valor Total:</label>
            <input type="number" id="valorTotalFactura" name="valorTotalFactura" required>

            <label for="cliente_idCliente">ID de Cliente:</label>
            <input type="text" id="cliente_idCliente" name="cliente_idCliente" required>

            <label for="usuario_idUsuario">ID de Usuario:</label>
            <input type="text" id="usuario_idUsuario" name="usuario_idUsuario" required>

            <label for="pedido_idPedido">ID de Pedido:</label>
            <input type="text" id="pedido_idPedido" name="pedido_idPedido" required>

            <input type="submit" value="Salir">
        </form>
    </div>
</body>
<?php include '../compartido/footer.php'; ?>
</html>