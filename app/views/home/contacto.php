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
<div class="cliente-wrap">
    <h2>PQRS / Contacto</h2>
    <?php if (!empty($mensaje)): ?>
        <p class="<?= !empty($esError) ? 'cliente-error' : 'cliente-ok' ?>" role="<?= !empty($esError) ? 'alert' : 'status' ?>"><?= e($mensaje) ?></p>
    <?php endif; ?>
    <div class="cliente-panel">
        <h3><i class="fas fa-envelope"></i> Envíanos tu solicitud</h3>
        <form method="POST" action="<?= url('contacto/index') ?>">
            <div class="cliente-form">
                <div class="campo">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" maxlength="20" value="<?= e($formData['nombre'] ?? '') ?>" required>
                </div>
                <div class="campo">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" maxlength="20" value="<?= e($formData['apellido'] ?? '') ?>" required>
                </div>
                <div class="campo">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" maxlength="20" value="<?= e($formData['telefono'] ?? '') ?>">
                </div>
                <div class="campo">
                    <label for="correo">Correo</label>
                    <input type="email" id="correo" name="correo" maxlength="50" value="<?= e($formData['correo'] ?? '') ?>" required>
                </div>
                <div class="campo ancho-total">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" maxlength="50" value="<?= e($formData['direccion'] ?? '') ?>">
                </div>
                <fieldset class="campo ancho-total ferreterias-destino">
                    <legend>Enviar a una o varias ferreterías</legend>
                    <p class="ferreterias-ayuda">Selecciona quién debe recibir tu petición.</p>
                    <?php if (empty($ferreterias)): ?>
                        <p>No hay ferreterías activas disponibles para recibir solicitudes.</p>
                    <?php else: ?>
                        <div class="ferreterias-opciones">
                            <?php foreach ($ferreterias as $ferreteria): ?>
                                <?php $ferreteriaId = (int)$ferreteria['id']; ?>
                                <label class="ferreteria-opcion">
                                    <input
                                        type="checkbox"
                                        name="ferreterias[]"
                                        value="<?= $ferreteriaId ?>"
                                        <?= in_array($ferreteriaId, $ferreteriasSeleccionadas ?? [], true) ? 'checked' : '' ?>>
                                    <span><?= e($ferreteria['nombre']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </fieldset>
                <div class="campo ancho-total">
                    <label for="motivo">Motivo</label>
                    <textarea id="motivo" name="motivo" maxlength="250" required><?= e($formData['motivo'] ?? '') ?></textarea>
                </div>
            </div>
            <div class="cliente-acciones">
                <button type="submit" class="btn-cliente" <?= empty($ferreterias) ? 'disabled' : '' ?>><i class="fas fa-paper-plane"></i> Enviar</button>
            </div>
        </form>
    </div>
</div>
<?php require APP_PATH . '/views/partials/footer.php'; ?>
</body></html>
