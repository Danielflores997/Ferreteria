<div id="menu-lateral">
    <h3><?= e($rolNombre ?? 'Usuario') ?></h3>
    <div id="foto">
        <img src="<?= e($fotoPerfil ?? DEFAULT_AVATAR) ?>" alt="Foto de perfil">
    </div>
    <div class="nom-usuario">
        <h3>Bienvenido:<br><?= e($correo ?? '') ?></h3>
    </div>
    <select id="selec-admin" onchange="if(this.value) location.href=this.value;">
        <option selected disabled>Opciones</option>
        <?php foreach (($menuItems ?? []) as $item): ?>
            <option value="<?= url($item['url']) ?>"><?= e($item['label']) ?></option>
        <?php endforeach; ?>
    </select>
</div>
