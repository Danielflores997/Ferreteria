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
            'css' => ['css/menu.css', 'css/footer.css', 'css/cliente.css']
        ]);
    }

    public function actualizarFoto()
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioModel = $this->model('Usuario');

            if (isset($_POST['quitar'])) {
                $usuarioModel->updateFoto($_SESSION['correo'], '');
                $this->redirect('cliente/perfil');
            }

            $subida = $this->guardarFotoSubida('archivo');
            $foto = $subida ?? trim($_POST['foto'] ?? '');
            if ($foto !== '') {
                $usuarioModel->updateFoto($_SESSION['correo'], $foto);
            }
        }
        $this->redirect('cliente/perfil');
    }

    public function carrito()
    {
        $this->view('home/carrito', [
            'title' => 'Carrito',
            'css' => ['css/menu.css', 'css/footer.css', 'css/cliente.css']
        ]);
    }

    public function misCompras()
    {
        $this->requireLogin();
        $usuario = $this->model('Usuario')->findByCorreo($_SESSION['correo']);
        $compras = [];
        if ($usuario) {
            $all = $this->model('Compra')->allConDetalle($usuario['documentoUsuario'] ?? '');
            // filter to current user id if possible
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT c.id, p.nombreProductos AS producto, c.cantidad, c.fecha
                FROM compras c JOIN productos p ON c.producto_id = p.idProducto
                WHERE c.usuario_id = ? ORDER BY c.id DESC");
            $uid = (int)$usuario['idUsuario'];
            $stmt->bind_param('i', $uid);
            $stmt->execute();
            $compras = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        $this->view('home/mis_compras', [
            'title' => 'Mis compras',
            'compras' => $compras,
            'usuario' => $usuario,
            'css' => ['css/menu.css', 'css/footer.css', 'css/cliente.css']
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
        if (!$usuario) {
            $this->json(['success' => false, 'message' => 'Usuario no encontrado']);
        }
        $compraModel = $this->model('Compra');
        $productoModel = $this->model('Producto');
        foreach ($input['items'] as $item) {
            $idRaw = $item['idProducto'] ?? '';
            $prod = $productoModel->find((int)$idRaw);
            if (!$prod) {
                $prod = $productoModel->findByCodigo((string)$idRaw);
            }
            if (!$prod) continue;
            $cant = max(1, (int)($item['cantidad'] ?? 1));
            if ((int)$prod['stockProducto'] < $cant) {
                $this->json(['success' => false, 'message' => 'Stock insuficiente para ' . $prod['nombreProductos']]);
            }
            $compraModel->create((int)$usuario['idUsuario'], (int)$prod['idProducto'], $cant);
            $productoModel->restarStock($prod['codigoProducto'], $cant);
        }
        $this->json(['success' => true, 'message' => 'Compra registrada']);
    }
}
