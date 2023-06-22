<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cotizaciones.css">
    <title>Cotizaciones</title>
</head>
    <body> 
    <?php
    include 'compartido/menu.php';
    ?>
        <main class="Contenedorgestioncliente">
            <section class="contenedor_foto2gescli">
                <div class="info-usuario2">
                    <div>
                        <p>Administrador</p>
                        <figure>
                            <img src="../imagenes/download.jpg" alt="">
                        </figure>
                    </div>
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
                                <h1>Cotizaciones</h1>
                            </div>
                                <div class="contenedorbotongesclie">

                                    <table class="Contenedortablagesclie">
                                        <tr class="centrartitulotabla">
                                            <td class="congesclinombre">N-cotizacion</td>
                                            <td class="congesclinombre" >Cliente</td>
                                            <td class="congesclinombre">Correo</td>
                                            <td class="congesclinombre"> Fecha</td>
                                        </tr>
                                        <tr>
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
                                        </tr>
                                        <tr>
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
                                        </tr>
                                </table>
                                <div class="contenedorbotongesclie">
                                    <div class="contenedortilulo">
                                        <h1>N# Cotizaciones</h1>
                                    </div>
                                    <table class="Contenedortablagesclie">
                                        <tr class="centrartitulotabla">
                                            <td class="congesclinombre">Cantidad</td>
                                            <td class="congesclinombre" >Descripcion</td>
                                            <td class="congesclinombre">Precio</td>
                                            <td class="congesclinombre">Descuento</td>
                                            <td class="congesclinombre">Producto</td>
                                        </tr>
                                        <tr>
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
                                        </tr>
                                        <tr>
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
                                        </tr>
                                    </table>
                                </div>  
                            </div>
                            <section>
                                <div class="contenedormensajegesclie">
                                    <form class="tablaingresomensaje" action="">
                                        <label class="mensaje" for="Mensaje">
                                            <span class="mensagesclie">Mensaje</span><br>
                                            <input class="contenidomensajegesclie" type="text" id="Mensaje"placeholder>
                                        </label>
                                    </form>
                                    <form class="tablaingresomensaje" action="">
                                        <label class="mensaje" for="Mensaje">
                                            <span class="mensagesclie">Respuesta</span><br>
                                            <input class="contenidomensajegesclie" type="text" id="Mensaje"placeholder>
                                        </label>
                                    </form>
                                    <div class="bottonenviarcancelar">
                                        <button class="boton-c">Enviar</button>
                                        <button  class="boton-c">Cancelar</button>
                                    </div>
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