<?php
class ClienteController extends Controller
{
    public function perfil()
    {
        $this->requireLogin();
        $usuario = $this->model('Usuario')->findByCorreo($_SESSION['correo']);
        $this->view('home/perfil', [
            'title' => 'Mi perfil',
            'usuario' => $usuario,
            'fotoPerfil' => $this->currentUserPhoto(),
            'css' => ['css/perfil.css', 'css/menu.css', 'css/footer.css']
        ]);
    }

    public function carrito()
    {
        $this->view('home/carrito', [
            'title' => 'Carrito',
            'css' => ['css/carrito.css', 'css/menu.css', 'css/footer.css']
        ]);
    }

    public function procesarCompra()
    {
        $this->requireLogin();
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input || empty($input['items'])) {
            $this->json(['success' => false, 'message' => 'Carrito vacío']);
        }
        $usuario = $this->model('Usuario')->findByCorreo($_SESSION['correo']);
        $compraModel = $this->model('Compra');
        $productoModel = $this->model('Producto');
        foreach ($input['items'] as $item) {
            $prod = $productoModel->findByCodigo($item['idProducto'] ?? '') ?: $productoModel->find((int)($item['idProducto'] ?? 0));
            if (!$prod) continue;
            $cant = (int)($item['cantidad'] ?? 1);
            $compraModel->create((int)$usuario['idUsuario'], (int)$prod['idProducto'], $cant);
            $productoModel->restarStock($prod['codigoProducto'], $cant);
        }
        $this->json(['success' => true, 'message' => 'Compra registrada']);
    }
}
