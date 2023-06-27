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
                <option value="index.html">Inicio</option>
                <option value="inventario.html">Gestión Catalogo e Inventario</option>
                <option value="gestionarFuncionarios.html">Gestionar Usuarios</option>
                <option value="ventas.html">Ventas</option>
            </select>
            
        </div>

        <div class="inventario">
            <h4 id="titulo-tabla">Documento de Venta</h4>
            <div id="conten-venta">
                <form id="formulario-venta" action="">
                
                <div class="input-izquierda">
                    <label for="factura">Factura Nº</label>
                    <input type="text" id="factura" placeholder="Factura">
                </div>
                <div class="input-derecha">
                    <label for="codigo">Código</label>
                    <input type="text" id="codigo" placeholder="Código">
                </div>
                <div class="input-izquierda">
                    <label for="stock">Stock</label>
                    <input id="stock" type="text" placeholder="Stock">
                </div>
                <div class="input-derecha">
                    <label for="categoria">Categoria</label>
                    <input type="" id="categoria" placeholder="Categoria">
                </div>
                <div class="input-izquierda">
                    <label for="producto">Producto</label>
                    <input type="text" id="producto" placeholder="Producto">
                </div>
                <div class="input-izquierda">
                    <label for="descuento">Precio UNI</label>
                    <input type="text" id="Precio" placeholder="Precio UNI">
                </div>
                <div class="input-derecha">
                    <label for="cantidad">Cantidad</label>
                    <input type="text" id="cantidad" placeholder="Cantidad">
                </div>
                
                </form>
            </div>
            <div id="conten-botones">
                <button id="btn-venta"><i class="far fa-save"></i><i class="fas fa-times-circle"></i> Cancelar</button>
                <button id="btn-venta"><i class="fas fa-save"></i><i class="fas fa-arrow-circle-right"></i> Guardar</button>
                <button id="btn-venta"><i class="fa-solid fa-plus"></i> Agregar</button>
            </div>
            <div id="tabla">
            <table>
                <tr>
                <th id="celda-principal">Código</th>
                <th id="celda-principal">Cantidad</th>
                <th id="celda-principal">Descripción</th>
                <th id="celda-principal">Precio</th>
                <th id="celda-principal">Descuento</th>
                <th id="celda-principal">Total</th>
                <th id="celda-principal">Acciones</th>
                </tr>
                <tr>
                <td>Texto celda 1</td>
                <td>Texto celda 2</td>
                <td>Texto celda 3</td>
                <td>Texto celda 4</td>
                <td>Texto celda 5</td>
                <td>Texto celda 7</td>
                <td class="acciones"><BUtton><i class="fa-solid fa-pencil" title="Modificar"></i></BUtton><BUtton><i class="fa-solid fa-trash" title="Eliminar"></i></BUtton></td>
                </tr>
                <tr>
                <td>Texto celda 7</td>
                <td>Texto celda 8</td>
                <td>Texto celda 9</td>
                <td>Texto celda 11</td>
                <td>Texto celda 12</td>
                <td>Texto celda 12</td>
                <td class="acciones"><BUtton><i class="fa-solid fa-pencil" title="Modificar"></i></BUtton><BUtton><i class="fa-solid fa-trash" title="Eliminar"></i></BUtton></td>
                </tr>
                <tr>
                <td>Texto celda 7</td>
                <td>Texto celda 7</td>
                <td>Texto celda 9</td>
                <td>Texto celda 10</td>
                <td>Texto celda 11</td>
                <td>Texto celda 12</td>
                <td class="acciones"><BUtton><i class="fa-solid fa-pencil" title="Modificar"></i></BUtton><BUtton><i class="fa-solid fa-trash" title="Eliminar"></i></BUtton></td>
                </tr>
                <tr>
                <td>Texto celda 7</td>
                <td>Texto celda 7</td>
                <td>Texto celda 8</td>
                <td>Texto celda 10</td>
                <td>Texto celda 11</td>
                <td>Texto celda 12</td>
                <td class="acciones"><BUtton><i class="fa-solid fa-pencil" title="Modificar"></i></BUtton><BUtton><i class="fa-solid fa-trash" title="Eliminar"></i></BUtton></td>
                </tr>
                <tr>
                <td>Texto celda 7</td>
                <td>Texto celda 8</td>
                <td>Texto celda 8</td>
                <td>Texto celda 9</td>
                <td>Texto celda 11</td>
                <td>Texto celda 12</td>
                <td class="acciones"><BUtton><i class="fa-solid fa-pencil" title="Modificar"></i></BUtton><BUtton><i class="fa-solid fa-trash" title="Eliminar"></i></BUtton></td>
                </tr>
                <tr>
                <td>Texto celda 7</td>
                <td>Texto celda 8</td>
                <td>Texto celda 9</td>
                <td>Texto celda 9</td>
                <td>Texto celda 11</td>
                <td>Texto celda 12</td>
                <td class="acciones"><BUtton><i class="fa-solid fa-pencil" title="Modificar"></i></BUtton><BUtton><i class="fa-solid fa-trash" title="Eliminar"></i></BUtton></td>
                </tr>
                <tr>
                <td>Texto celda 7</td>
                <td>Texto celda 8</td>
                <td>Texto celda 9</td>
                <td>Texto celda 9</td>
                <td>Texto celda 11</td>
                <td>Texto celda 12</td>
                <td class="acciones"><BUtton><i class="fa-solid fa-pencil" title="Modificar"></i></BUtton><BUtton><i class="fa-solid fa-trash" title="Eliminar"></i></BUtton></td>
                </tr>
                <tr>
                <td>Texto celda 7</td>
                <td>Texto celda 8</td>
                <td>Texto celda 8</td>
                <td>Texto celda 9</td>
                <td>Texto celda 11</td>
                <td>Texto celda 12</td>
                <td class="acciones"><BUtton><i class="fa-solid fa-pencil" title="Modificar"></i></BUtton><BUtton><i class="fa-solid fa-trash" title="Eliminar"></i></BUtton></td>
                </tr>
                <tr>
                <td>Texto celda 7</td>
                <td>Texto celda 8</td>
                <td>Texto celda 9</td>
                <td>Texto celda 10</td>
                <td>Texto celda 11</td>
                <td>Texto celda 12</td>
                <td class="acciones"><BUtton><i class="fa-solid fa-pencil" title="Modificar"></i></BUtton><BUtton><i class="fa-solid fa-trash"></i></BUtton></td>
                </tr>
                <tr>
                    <td id="vacio"></td><td id="vacio"></td><td id="vacio"></td><td id="vacio"></td><th id="celda-principal">Subtotal</th><td>00000</td><td id="vacio"></td>
                </tr>
                <tr>
                    <td id="vacio"></td><td id="vacio"></td><td id="vacio"></td><td id="vacio"></td><th id="celda-principal">Impuesto</th><td>19%</td><td id="vacio"></td>
                </tr>
                <tr>
                    <td id="vacio"></td><td id="vacio"></td><td id="vacio"></td><td id="vacio"></td><th id="celda-principal">Total</th><td>000.0000</td><td id="vacio"></td>
                </tr>
            </table>
            </div>
        </div>
        </div>
        
    
<div class="slider">
    <ul>
        <li>
            <img src="../imagenes/ferreteria-norte-banner.jpg" alt="Herramientas1">
        </li>
        <li>
            <img src="../imagenes/herramientas-png.png" alt="Herramientas2">
        </li>
        <li>
            <img src="../imagenes/slide1-1ferreteria.png" alt="Herramientas3">
        </li>
        <li>
            <img src="../imagenes/ferreteria-ferromar-.jpg" alt="Herramientas4">
        </li>
    </ul>
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