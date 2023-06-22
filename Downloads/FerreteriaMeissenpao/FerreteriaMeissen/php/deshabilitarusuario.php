<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/deshabilitarusuario.css">
    <title>deshabilitarusuario</title>
</head>
    <body>
    <?php
    include 'compartido/menu.php';
    ?>           
        <main class="Contenedorgestioncliente">
            <section class="contenedor_foto3gescli">
                <div class="info-usuario3">
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
                                <h1>Deshabilitar usuario</h1>
                            </div>
                                <div class="contenedorbotongesclie">
                                    <div class="botonesbuscarcliente">
                                        <button class="botonbuscarsuperior" >Buscar</button>
                                        <button class="botonbuscarsuperior">ID Cliente</button>
                                    </div>
                                    <table class="Contenedortablagesclie">
                                        <tr class="centrartitulotabla">
                                            <td class="congesclinombre">Nombre</td>
                                            <td class="congesclinombre">Identificación</td>
                                            <td class="congesclinombre">Correo</td>
                                            <td class="congesclinombre"> Fecha Ingreso</td>
                                            <td class="congesclinombre">Seleccionar</td>
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
                                        <div class="contenedormensajegesclie">
                                            <form class="tablaingresomensaje" action="">
                                                <label class="mensaje" for="Mensaje">
                                                    <span class="mensagesclie">Mensaje</span><br>
                                                    <input class="contenidomensajegesclie" type="text" id="Mensaje"placeholder>
                                                </label>
                                            </form>
                                            <div class="bottonenviarcancelar">
                                                <button class="boton-c">Enviar</button>
                                                <button  class="boton-c">Cancelar</button>
                                            </div>
                                        </div>  
                                </div>                
            </section>      
        </main>
        <script src="https://kit.fontawesome.com/a432d16de7.js" crossorigin="anonymous"></script>  
        <?php
        include 'compartido/footer.php';
        ?>
    </body>
</html>