<link rel="stylesheet" href="<?= asset('css/menu.css') ?>">
<div class="encabezado">
    <header>
        <div class="titulo"><h1>FERRETERIA MEISSEN</h1></div>
        <div class="logo"><img src="<?= asset('imagenes/ferreteria.jpeg') ?>" alt="logo ferreteria"></div>
    </header>
    <nav class="navbar">
        <div class="lista">
            <a href="<?= url('home/nosotros') ?>" class="Catalogo">Nosotros</a>
            <a href="<?= url('home/index') ?>" class="Catalogo">Catálogo</a>
            <a href="<?= url('home/categoria/pinturas') ?>">Pintura</a>
            <a href="<?= url('home/categoria/electricas') ?>">Eléctricas</a>
            <a href="<?= url('home/categoria/herramientas') ?>">Herramientas</a>
            <a href="<?= url('home/categoria/accesorios') ?>">Accesorios</a>
            <a href="<?= url('home/categoria/carpinteria') ?>">Carpintería</a>
            <a href="<?= url('home/categoria/plomeria') ?>">Plomería</a>
            <a href="<?= url('home/categoria/jardineria') ?>">Jardinería</a>
            <a href="<?= url('home/categoria/cementos') ?>">Cementos</a>
            <a href="<?= url('home/categoria/tornilleria') ?>">Tornillería</a>
            <a href="<?= url('contacto/index') ?>">Contacto</a>
            <?php if (isLoggedIn()): ?>
                <?php if (currentRole() === 4): ?>
                    <a class="btn-login" href="<?= url('superadmin/index') ?>">Panel</a>
                <?php elseif (in_array(currentRole(), [1,2], true)): ?>
                    <a class="btn-login" href="<?= url('admin/index') ?>">Panel</a>
                <?php else: ?>
                    <a class="btn-login" href="<?= url('cliente/perfil') ?>">Mi Perfil</a>
                <?php endif; ?>
                <a class="btn-login" href="<?= url('auth/logout') ?>">Salir</a>
            <?php else: ?>
                <a class="btn-login" href="<?= url('auth/login') ?>">Acceder</a>
                <a class="btn-login" href="<?= url('auth/register') ?>">Regístrate</a>
            <?php endif; ?>
        </div>
    </nav>
</div>
<?php require APP_PATH . '/views/partials/carrito_flotante.php'; ?>
<?php require APP_PATH . '/views/partials/asistente_chat.php'; ?>
