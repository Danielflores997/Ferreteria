<?php

class PagesController
{
    public function nosotros(): void
    {
        require __DIR__ . '/../views/pages/nosotros.php';
    }

    public function registro(): void
    {
        require __DIR__ . '/../views/pages/registroCliente.php';
    }

    public function recuperarPassword(): void
    {
        require __DIR__ . '/../views/pages/confirmarContraseña.php';
    }
}
