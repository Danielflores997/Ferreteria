<div id="menu-lateral">
    <h3><?= e($rolNombre ?? 'Usuario') ?></h3>
    <div id="foto">
        <img src="<?= e($fotoPerfil ?? DEFAULT_AVATAR) ?>" alt="Foto de perfil" style="width:90px;height:90px;object-fit:cover;border-radius:50%">
    </div>
    <div class="nom-usuario">
        <h3>Bienvenido:<br><?= e($correo ?? '') ?></h3>
    </div>
    <label for="selec-admin" style="display:block;margin:.5rem 0 .25rem;font-size:.9rem">Menú</label>
    <select id="selec-admin" onchange="if(this.value) location.href=this.value;" style="width:90%;max-width:220px;padding:.35rem">
        <option selected disabled>Opciones</option>
        <?php foreach (($menuItems ?? []) as $item): ?>
            <option value="<?= url($item['url']) ?>"><?= e($item['label']) ?></option>
        <?php endforeach; ?>
    </select>
    <ul style="list-style:none;padding:.75rem 0 0;margin:0">
        <?php foreach (($menuItems ?? []) as $item): ?>
            <li style="margin:.35rem 0">
                <a href="<?= url($item['url']) ?>" style="text-decoration:none;color:inherit"><?= e($item['label']) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
