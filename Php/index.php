<?php
session_start();
require_once __DIR__ . '/../app/core/Tenant.php';
Tenant::resolve();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <title><?= htmlspecialchars(Tenant::nombre()) ?></title>
</head>

<body>
    <?php
    include "../compartido/menu.php";
    require_once __DIR__ . '/../app/config/database.php';
    $conn = db();
    ?>
    <div class="slider">
        <ul>
            <li><img src="../imagenes/ferreteria-norte-banner.jpg" alt="Herramientas1"></li>
            <li><img src="../imagenes/herramientas-png.png" alt="Herramientas2"></li>
            <li><img src="../imagenes/slide1-1ferreteria.png" alt="Herramientas3"></li>
            <li><img src="../imagenes/ferreteria-ferromar-.jpg" alt="Herramientas4"></li>
        </ul>
    </div>
    <h2 class="catalogo">Productos de <?= htmlspecialchars(Tenant::nombre()) ?></h2>
    <section class="contenedor">
        <div class="contenedor-items">
            <?php
            $tenantId = Tenant::id();
            $sql = "SELECT * FROM productos WHERE tenant_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $tenantId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="item">
                        <span class="titulo-item"><?= htmlspecialchars($row["nombreProductos"]) ?></span>
                        <img class="img-catalogo" src="<?= htmlspecialchars($row["imagen"]) ?>">
                        <span class="titulo-item"><?= htmlspecialchars($row["descripcionProducto"]) ?></span>
                        <span class="precio-item">$ <?= number_format($row["valorProducto"], 0, ',', '.') ?></span>
                        <button class="boton-item"
                            data-titulo="<?= htmlspecialchars($row["nombreProductos"]) ?>"
                            data-imagen="<?= htmlspecialchars($row["imagen"]) ?>"
                            data-precio="<?= htmlspecialchars($row["valorProducto"]) ?>"
                            data-idproducto="<?= htmlspecialchars($row["idProducto"]) ?>"
                            onclick="agregarAlCarrito(this)">
                            Agregar al Carrito
                        </button>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No hay productos disponibles para esta ferretería.</p>";
            }
            ?>
        </div>
        <div class="icono-carrito">
            <a href="../Php/carrito.php"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
    </section>
</body>
<?php include '../compartido/footer.php'; ?>
<script>
    function agregarAlCarrito(button) {
        var titulo = button.getAttribute('data-titulo');
        var imagen = button.getAttribute('data-imagen');
        var precio = button.getAttribute('data-precio');
        var idProducto = button.getAttribute('data-idproducto');
        button.textContent = 'Agregado al carrito';
        button.classList.remove('boton-item');
        button.classList.add('boton-agregado');

        var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];
        var productoExistente = carritoProductos.find(producto => producto.idProducto === idProducto);

        if (productoExistente) {
            productoExistente.cantidad++;
        } else {
            carritoProductos.push({
                idProducto: idProducto,
                titulo: titulo,
                imagen: imagen,
                precio: precio,
                cantidad: 1
            });
        }
        localStorage.setItem('carritoProductos', JSON.stringify(carritoProductos));
    }
</script>
</html>