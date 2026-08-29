<footer>
    <link rel="stylesheet" href="<?= asset('css/footer.css') ?>">
    <h4>Ferreteria Meissen</h4>
    <div class="enlaces">
        <ul>
            <li><a href="<?= url('contacto/index') ?>">Contacto</a></li>
            <li><a href="<?= url('home/nosotros') ?>">Nosotros</a></li>
            <li><a href="<?= url('home/index') ?>">Catalogo</a></li>
        </ul>
    </div>
    <h4>Redes sociales</h4>
    <div class="sociales">
        <div class="sociales-link">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-whatsapp"></i></a>
            <p>Derechos de autor &copy; <?= date('Y') ?> Ferretería Meissen. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>
