<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<?php foreach (($css ?? []) as $c): ?><link rel="stylesheet" href="<?= asset($c) ?>"><?php endforeach; ?>
<title><?= e($title) ?></title>
</head>
<body>
<?php require APP_PATH . '/views/partials/menu_publico.php'; ?>
<main class="nosotros-page">
    <section class="nosotros-hero">
        <div class="nosotros-hero-contenido">
            <span class="nosotros-etiqueta"><i class="fa-solid fa-screwdriver-wrench"></i> Un marketplace, muchas ferreterías</span>
            <h2>Todo lo que necesitas para construir, reparar y crear.</h2>
            <p>Conectamos ferreterías independientes en una sola plataforma para que descubras sus productos fácilmente y cada negocio pueda crecer con su propia identidad.</p>
            <a class="nosotros-boton" href="<?= url('home/index') ?>">Explorar catálogo <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="nosotros-hero-imagen">
            <img src="<?= asset('imagenes/ferreteria-norte-banner.jpg') ?>" alt="Productos y materiales de ferretería">
            <div class="nosotros-sello"><i class="fa-solid fa-store"></i><span>Negocios locales<br>conectados</span></div>
        </div>
    </section>

    <section class="nosotros-intro">
        <div class="nosotros-titulo-seccion">
            <span class="nosotros-kicker">Quiénes somos</span>
            <h2>La ferretería de siempre, conectada de una nueva forma</h2>
        </div>
        <p>Este proyecto es un marketplace multitenant que reúne varias ferreterías en un mismo espacio digital. Cada tienda administra sus productos, inventario y equipo de trabajo, mientras los clientes pueden encontrar artículos de distintos negocios desde un catálogo común.</p>
    </section>

    <section class="nosotros-caracteristicas" aria-label="Cómo funciona la plataforma">
        <article class="nosotros-card">
            <span class="nosotros-icono"><i class="fa-solid fa-shop"></i></span>
            <h3>Varias tiendas, un solo lugar</h3>
            <p>Reunimos ferreterías participantes para que sus catálogos sean fáciles de descubrir desde una sola plataforma.</p>
        </article>
        <article class="nosotros-card">
            <span class="nosotros-icono"><i class="fa-solid fa-boxes-stacked"></i></span>
            <h3>Administración independiente</h3>
            <p>Cada ferretería cuenta con su propio espacio de gestión para organizar productos, existencias y operaciones.</p>
        </article>
        <article class="nosotros-card">
            <span class="nosotros-icono"><i class="fa-solid fa-magnifying-glass"></i></span>
            <h3>Un catálogo compartido</h3>
            <p>Los clientes pueden explorar productos de las distintas tiendas y consultar opciones para sus proyectos.</p>
        </article>
    </section>

    <section class="nosotros-como-funciona">
        <div class="nosotros-como-imagen">
            <img src="<?= asset('imagenes/herramientas-png.png') ?>" alt="Herramientas para diferentes proyectos">
        </div>
        <div class="nosotros-como-contenido">
            <span class="nosotros-kicker">Una plataforma para conectar</span>
            <h2>Cada ferretería conserva su espacio y aporta al catálogo común</h2>
            <p>La arquitectura multitenant permite que distintos negocios compartan la plataforma sin mezclar su información administrativa. Así, cada equipo trabaja con sus propios datos y sus productos pueden formar parte de una experiencia de búsqueda más amplia.</p>
            <ul>
                <li><i class="fa-solid fa-check"></i> Los administradores gestionan la información de su ferretería.</li>
                <li><i class="fa-solid fa-check"></i> El catálogo permite descubrir productos de varias tiendas.</li>
                <li><i class="fa-solid fa-check"></i> La plataforma ofrece una administración central para los superadministradores.</li>
            </ul>
        </div>
    </section>

    <section class="nosotros-proposito">
        <div>
            <span class="nosotros-icono"><i class="fa-solid fa-bullseye"></i></span>
            <h3>Nuestro propósito</h3>
            <p>Facilitar el encuentro entre clientes que buscan materiales y herramientas, y ferreterías que quieren presentar y administrar su oferta en línea.</p>
        </div>
        <div>
            <span class="nosotros-icono"><i class="fa-solid fa-people-group"></i></span>
            <h3>Una red de negocios</h3>
            <p>Creemos en una experiencia digital que conecta comercios independientes y hace más sencillo explorar lo que cada uno tiene para ofrecer.</p>
        </div>
    </section>

    <section class="nosotros-cierre">
        <div>
            <span class="nosotros-kicker">¿Listo para empezar?</span>
            <h2>Encuentra lo que tu próximo proyecto necesita.</h2>
        </div>
        <a class="nosotros-boton" href="<?= url('home/index') ?>">Ver productos <i class="fa-solid fa-arrow-right"></i></a>
    </section>
</main>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body>
</html>
