<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fereteria meissen</title>
    <link rel="shortcut icon" href="assets/logo_proyecto.png.jpeg" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../css/role.css">
    <link rel="stylesheet" href="https://fontawesome.com/icons">
    <title>presentacion</title>
</head>
<body>

<?php
    include 'compartido/menu.php';
    ?>
    <main>
        <section class="presentation_container">
            <div>
                <h2 class="subtitulo">¡Todo lo que necesitas en un solo lugar!</h2>
            </div>
            <div class="navegar">
                <nav>
                    <a href="#">Administrador</a>
                    <a href="#">Vendedor</a>
                    <a href="#">cliente</a>
                </nav>
            </div>
        </section>
        <section class="container_nav">
            <div class="galeria-port">
                <div class="imagen-port">
                    <img src="../imagenes/admin..jpg" alt="">
                    <div class="hover-galeria">                      
                    </div>
                </div>
                    <div class="imagen-port">
                        <img src="../imagenes/vende.jpg" alt="">
                        <div class="hover-galeria">                           
                        </div>
                    </div>
                        <div class="imagen-port">
                            <img src="../imagenes/clientemasculino.avif" alt="">
                            <div class="hover-galeria">
                            </div>
                        </div>
                    </div>
        </section>
        <section class="sobre nosotros">
            <div class="container_nosotros">
                <h2 class="subtitulo">Quienes somos</h2>
                <div class="sobre-nosotros">
                    <img src="assets/nosotros.jpg" alt="" class="imagen-about-us">
                </div>
                <p>Somos una empresa distribuidora de productos ferreteros y materiales de construcción dirigidos a satisfacer las necesidades de nuestros clientes a través de un servido rápido y de calidad, con precios competitivos y con un personal calificado.</p>
            </div>
        </section>
    </main>
    <script src="https://kit.fontawesome.com/a432d16de7.js" crossorigin="anonymous"></script>  
    <?php
        include 'compartido/footer.php';
        ?>
</body>
</html>