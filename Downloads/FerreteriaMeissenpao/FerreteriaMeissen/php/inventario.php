<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inventario.css">
    <title>Document</title>
</head>
    <body> 
    <?php
    include 'compartido/menu.php';
    ?>

        
    <main class="ContenedorInventarioAdmin">
            <section class="contenedor_foto2gescli">
                <div class="info-usuario2">
                        <p>Administrador</p>
                        <figure>
                            <img src="../img/download.jpg" alt="">
                        </figure>
                    </div>
                        <div class="botonesgesclie">
                            <select id="menu-administrador" onchange="location.href=this.value;">
                                <option value="" selected>Seleccione una opción</option>
                                <option value="../inicio/index.php">Inicio</option>
                                <option value="../cotizacionadmin/cotizacionadm.php">Cotizaciones</option>
                                <option value="../catalogo/gestionarCATALOGO/gesticatalogo.php">Gestionar Catálogo</option>
                                <option value="../diseno/Gestionarclientes.php">Gestionar Clientes</option>
                                <option value="../inventario/admininventario.php">Inventario</option>
                                <option value="entrada">Entrada</option>
                                <option value="salidas">Salidas</option>
                                <option value="../Registro/registro_funcionario.php">Registro Funcionarios</option>
                                <option value="../Deshabilitar/usuario.php">Deshabilitar Usuario</option>
                                <option value="../diseno/ventaadministracion.php">Ventas</option>
                              </select>
                        </div>    
            </section>
                    <section class="seccioncontenedor2">
                            <div class="contenedortilulo">
                                <h1>Inventario</h1>
                            </div>
                                <div class="contenedorbotongesclie">
                                    <div class="botonesbuscarcliente">
                                        <button class="botonbuscarsuperior" >Buscar</button>
                                        <button class="botonbuscarsuperior">ID Producto</button>
                                    </div>
                                    <table class="Contenedortablagesclie">
                                        <tr class="centrartitulotabla">
                                            <td class="congesclinombre">Nº</td>
                                            <td class="congesclinombre">Producto</td>
                                            <td class="congesclinombre">Entrada</td>
                                            <td class="congesclinombre"> Fecha Entrada</td>
                                            <td class="congesclinombre">Salida</td>
                                            <td class="congesclinombre">Fecha Salida</td>
                                            <td class="congesclinombre">Stock</td>
                                        </tr>
                                        <tr>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                        </tr>
                                        <tr>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                        </tr>
                                        <tr>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                        </tr>
                                        <tr>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                            <td class="congesclinombre"></td>
                                        </tr>
                                </table>
                                <br> <br>
                                <section class="bottonenviarcancelar">

                                            <class="bottonenviar">
                                                    <button class="boton-c1">Enviar</button>  
                                                    <class="bottoncancelar">
                                                    <button class="boton-c2">Cancelar</button>
                                                
                                            </div>
                                            </section>        
            </section>      
    </main>
        <script src="https://kit.fontawesome.com/a432d16de7.js" crossorigin="anonymous"></script>  
        
        <?php
        include 'compartido/footer.php';
        ?>

    </body>
</html>