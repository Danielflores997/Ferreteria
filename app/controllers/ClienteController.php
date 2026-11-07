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
        if (!is_array($input) || !isset($input['items']) || !is_array($input['items']) || $input['items'] === []) {
            $this->json(['success' => false, 'message' => 'El carrito está vacío o no es válido'], 400);
        }
        $usuario = $this->model('Usuario')->findByCorreo($_SESSION['correo']);
        if (!$usuario) {
            $this->json(['success' => false, 'message' => 'Usuario no encontrado'], 401);
        }
        if (count($input['items']) > 100) {
            $this->json(['success' => false, 'message' => 'El carrito supera el máximo de 100 productos'], 422);
        }

        $quantities = [];
        foreach ($input['items'] as $item) {
            if (!is_array($item)) {
                $this->json(['success' => false, 'message' => 'Línea de carrito inválida'], 422);
            }
            $productId = filter_var($item['idProducto'] ?? null, FILTER_VALIDATE_INT);
            $quantity = filter_var($item['cantidad'] ?? null, FILTER_VALIDATE_INT);
            if ($productId === false || $productId < 1 || $quantity === false || $quantity < 1 || $quantity > 1000) {
                $this->json(['success' => false, 'message' => 'Producto o cantidad inválidos'], 422);
            }
            $quantities[$productId] = ($quantities[$productId] ?? 0) + $quantity;
            if ($quantities[$productId] > 1000) {
                $this->json(['success' => false, 'message' => 'La cantidad máxima por producto es 1000'], 422);
            }
        }
        ksort($quantities, SORT_NUMERIC);

        $compraModel = $this->model('Compra');
        $productoModel = $this->model('Producto');
        $checkoutId = bin2hex(random_bytes(16));
        $db = $productoModel->getConnection();
        $db->begin_transaction();
        try {
            foreach ($quantities as $productId => $quantity) {
                $prod = $productoModel->findPublic((int)$productId);
                if (!$prod) {
                    throw new DomainException('Producto no disponible: ' . $productId);
                }
                $tenantId = (int)$prod['tenant_id'];
                $stmt = $db->prepare(
                    "UPDATE productos SET stockProducto = stockProducto - ? WHERE idProducto = ? AND tenant_id = ? AND stockProducto >= ?"
                );
                $stmt->bind_param('iiii', $quantity, $productId, $tenantId, $quantity);
                if (!$stmt->execute() || $stmt->affected_rows !== 1) {
                    throw new DomainException('Stock insuficiente para ' . $prod['nombreProductos']);
                }
                if (!$compraModel->create(
                    (int)$usuario['idUsuario'],
                    (int)$prod['idProducto'],
                    $quantity,
                    $tenantId,
                    $checkoutId
                )) {
                    throw new RuntimeException('No se pudo registrar una línea del checkout.');
                }
            }
            $db->commit();
        } catch (DomainException $e) {
            $db->rollback();
            $this->json(['success' => false, 'message' => $e->getMessage()], 409);
        } catch (mysqli_sql_exception | RuntimeException $e) {
            $db->rollback();
            error_log('Checkout failed: ' . $e->getMessage());
            $this->json(['success' => false, 'message' => 'No se pudo completar la compra. No se aplicaron cambios.'], 500);
        }
        $this->json(['success' => true, 'message' => 'Compra registrada', 'checkout_id' => $checkoutId]);
    }
}
