<link rel="stylesheet" href="<?= asset('css/asistente.css') ?>?v=<?= filemtime(PUBLIC_PATH . '/css/asistente.css') ?>">
<button
    type="button"
    id="asistente-abrir"
    class="asistente-abrir"
    aria-label="Abrir asistente de búsqueda"
    aria-expanded="false"
    aria-controls="asistente-panel"
>
    <i class="fa-solid fa-robot" aria-hidden="true"></i>
    <span>¿Qué necesitas?</span>
</button>

<section id="asistente-panel" class="asistente-panel" aria-label="Asistente de búsqueda" hidden>
    <header class="asistente-cabecera">
        <div>
            <strong>Asistente ferretero</strong>
            <span>Encuentra productos describiendo lo que buscas</span>
            <span>No incluyas datos personales. La consulta se procesa con Google Gemini.</span>
        </div>
        <button type="button" id="asistente-cerrar" class="asistente-cerrar" aria-label="Cerrar asistente">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
    </header>
    <div id="asistente-mensajes" class="asistente-mensajes" aria-live="polite" aria-relevant="additions text">
        <p class="asistente-mensaje asistente-mensaje-bot">¡Hola! Cuéntame qué necesitas para tu proyecto y buscaré opciones del catálogo.</p>
    </div>
    <form id="asistente-formulario" class="asistente-formulario" data-endpoint="<?= e(url('asistente/consultar')) ?>">
        <label class="sr-only" for="asistente-pregunta">Describe el producto que necesitas</label>
        <input id="asistente-pregunta" name="message" type="text" maxlength="500" required autocomplete="off" placeholder="Ej.: pintura para exterior">
        <button type="submit" aria-label="Enviar pregunta">
            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
        </button>
    </form>
</section>
<script src="<?= asset('js/asistente.js') ?>?v=<?= filemtime(PUBLIC_PATH . '/js/asistente.js') ?>" defer></script>
