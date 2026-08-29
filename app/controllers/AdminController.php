<?php
class AdminController extends Controller
{
    private function adminData(array $extra = [])
    {
        return array_merge([
            'fotoPerfil' => $this->currentUserPhoto(),
            'rolNombre' => $this->rolNombre(),
            'correo' => $_SESSION['correo'] ?? '',
            'menuItems' => $this->menuItems(),
        ], $extra);
    }

    private function menuItems()
    {
        return [
            ['label' => 'Inicio', 'url' => 'admin/index'],
            ['label' => 'Gestión Catálogo e Inventario', 'url' => 'admin/inventario'],
            ['label' => 'Vista catálogo', 'url' => 'admin/catalogo'],
            ['label' => 'Gestionar Usuarios', 'url' => 'admin/usuarios'],
            ['label' => 'Gestionar proveedores', 'url' => 'admin/proveedores'],
            ['label' => 'Ventas', 'url' => 'admin/ventas'],
            ['label' => 'Compras carrito', 'url' => 'admin/compras'],
            ['label' => 'Peticiones', 'url' => 'admin/peticiones'],
        ];
    }

    public function index()
    {
        $this->requireStaff();
        $usuario = $this->model('Usuario')->findByCorreo($_SESSION['correo']);
        $this->view('admin/dashboard', $this->adminData([
            'title' => 'Panel Administrador',
            'usuario' => $usuario,
            'css' => ['css/vistaAdmin.css', 'css/perfil.css', 'css/footer.css']
        ]));
    }

    public function catalogo()
    {
        $this->requireStaff();
        $productos = $this->model('Producto')->all();
        $this->view('admin/catalogo', $this->adminData([
            'title' => 'Catálogo Admin',
            'productos' => $productos,
            'css' => ['css/vistaCatalogo.css', 'css/footer.css']
        ]));
    }

    public function inventario()
    {
        $this->requireStaff();
        $productoModel = $this->model('Producto');
        $proveedorModel = $this->model('Proveedor');
        $categoriaModel = $this->model('Categoria');

        // AJAX proveedor lookup
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idProveedor']) && !isset($_POST['guardar'])) {
            $prov = $proveedorModel->find((int)$_POST['idProveedor']);
            $this->json($prov);
        }

        $mensaje = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
            $idProv = trim($_POST['idProveedor'] ?? '');
            if ($idProv !== '' && !$proveedorModel->exists($idProv)) {
                $proveedorModel->create([
                    'id' => $idProv,
                    'nombre' => $_POST['nombreProveedor'] ?? '',
                    'apellido' => $_POST['apellidoProveedor'] ?? '',
                    'telefono' => $_POST['telefonoProveedor'] ?? '',
                    'direccion' => $_POST['direccionProveedor'] ?? '',
                    'correo' => $_POST['correoProveedor'] ?? '',
                ]);
            }

            $codigo = trim($_POST['codigo'] ?? '');
            $cantidad = (int)($_POST['cantidad'] ?? 0);
            $existente = $productoModel->findByCodigo($codigo);
            $categorias = $categoriaModel->map();
            $catId = $_POST['categoria'] ?? '';
            $catNombre = $categorias[$catId] ?? $catId;

            if ($existente) {
                $productoModel->sumarStock($codigo, $cantidad);
                $mensaje = 'El producto ya existe. Se ha actualizado el stock.';
            } else {
                $productoModel->create([
                    'codigo' => $codigo,
                    'nombre' => $_POST['producto'] ?? '',
                    'precio' => (float)($_POST['precio'] ?? 0),
                    'stock' => $cantidad,
                    'descripcion' => $_POST['descripcion'] ?? '',
                    'categoria' => $catNombre,
                    'imagen' => $_POST['imagen'] ?? '',
                ]);
                $mensaje = 'Nuevo producto agregado correctamente.';
            }
        }

        $this->view('admin/inventario', $this->adminData([
            'title' => 'Inventario',
            'productos' => $productoModel->all(),
            'ultimoCodigo' => $productoModel->ultimoCodigo(),
            'categorias' => $categoriaModel->all(),
            'mensaje' => $mensaje,
            'css' => ['css/inventario.css', 'css/footer.css']
        ]));
    }

    public function buscarProducto()
    {
        $this->requireStaff();
        $term = $_POST['searchTerm'] ?? '';
        $rows = $this->model('Producto')->all($term);
        $html = '<tr>
            <th id="celda-principal">Código</th>
            <th id="celda-principal">Producto</th>
            <th id="celda-principal">Precio</th>
            <th id="celda-principal">Cantidad</th>
            <th id="celda-principal">Descripción</th>
            <th id="celda-principal">Categoría</th>
            <th id="celda-principal">Acciones</th>
        </tr>';
        foreach ($rows as $row) {
            $id = (int)$row['idProducto'];
            $html .= '<tr>
                <td>' . e($row['codigoProducto']) . '</td>
                <td>' . e($row['nombreProductos']) . '</td>
                <td>' . e($row['valorProducto']) . '</td>
                <td>' . e($row['stockProducto']) . '</td>
                <td>' . e($row['descripcionProducto']) . '</td>
                <td>' . e($row['nombreCategoria']) . '</td>
                <td class="acciones">
                    <a href="' . url('admin/editarProducto/' . $id) . '"><i class="fas fa-edit"></i></a>
                    <form action="' . url('admin/eliminarProducto') . '" method="POST" style="display:inline" onsubmit="return confirm(\'¿Eliminar producto?\');">
                        <input type="hidden" name="id" value="' . $id . '">
                        <button type="submit"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>';
        }
        echo $html;
        exit;
    }

    public function editarProducto($id = null)
    {
        $this->requireStaff();
        $productoModel = $this->model('Producto');
        $categoriaModel = $this->model('Categoria');
        $id = (int)($id ?? ($_POST['id'] ?? 0));

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
            $categorias = $categoriaModel->map();
            $catId = $_POST['categoria'] ?? '';
            $catNombre = $categorias[$catId] ?? $catId;
            $productoModel->update($id, [
                'codigo' => $_POST['codigo'] ?? '',
                'nombre' => $_POST['nombre'] ?? '',
                'precio' => (float)($_POST['valor'] ?? 0),
                'stock' => (int)($_POST['stock'] ?? 0),
                'descripcion' => $_POST['descripcion'] ?? '',
                'categoria' => $catNombre,
                'imagen' => $_POST['imagen'] ?? '',
            ]);
            $this->redirect('admin/inventario');
        }

        $producto = $productoModel->find($id);
        if (!$producto) {
            $this->redirect('admin/inventario');
        }

        $this->view('admin/editar_producto', $this->adminData([
            'title' => 'Editar producto',
            'producto' => $producto,
            'categorias' => $categoriaModel->map(),
            'css' => ['css/editar.css', 'css/footer.css']
        ]));
    }

    public function eliminarProducto()
    {
        $this->requireStaff();
        if (isset($_POST['id'])) {
            $this->model('Producto')->delete((int)$_POST['id']);
        }
        $this->redirect('admin/inventario');
    }

    public function bajoStock()
    {
        $this->requireStaff();
        $this->json($this->model('Producto')->bajoStock());
    }

    public function usuarios()
    {
        $this->requireAdmin();
        $this->view('admin/usuarios', $this->adminData([
            'title' => 'Gestionar Usuarios',
            'usuarios' => $this->model('Usuario')->all(),
            'clientes' => $this->model('Cliente')->all(),
            'css' => ['css/gestionarFuncionarios.css', 'css/footer.css']
        ]));
    }

    public function buscarUsuario()
    {
        $this->requireAdmin();
        $rows = $this->model('Usuario')->all($_POST['searchTerm'] ?? '');
        $html = '<tr>
            <th id="celda-principal">Tipo Documento</th>
            <th id="celda-principal">Identificación</th>
            <th id="celda-principal">Nombre</th>
            <th id="celda-principal">Apellido</th>
            <th id="celda-principal">Correo</th>
            <th id="celda-principal">Estado</th>
            <th id="celda-principal">Rol</th>
            <th id="celda-principal">Acciones</th>
        </tr>';
        foreach ($rows as $row) {
            $id = (int)$row['idUsuario'];
            $html .= '<tr>
                <td>' . e($row['tipoDocumentoUsuario']) . '</td>
                <td>' . e($row['documentoUsuario']) . '</td>
                <td>' . e($row['nombresUsuario']) . '</td>
                <td>' . e($row['apellidosUsuario']) . '</td>
                <td>' . e($row['correo']) . '</td>
                <td>' . e($row['estadoUsuario']) . '</td>
                <td>' . e($row['rol_idRol']) . '</td>
                <td class="acciones">
                    <a href="' . url('admin/editarUsuario/' . $id) . '"><i class="fas fa-edit"></i></a>
                    <form action="' . url('admin/eliminarUsuario') . '" method="POST" style="display:inline" onsubmit="return confirm(\'¿Eliminar usuario?\');">
                        <input type="hidden" name="id" value="' . $id . '">
                        <button type="submit"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>';
        }
        echo $html; exit;
    }

    public function buscarCliente()
    {
        $this->requireAdmin();
        $rows = $this->model('Cliente')->all($_POST['searchTerm'] ?? '');
        $html = '<tr>
            <th id="celda-principal">Tipo Documento</th>
            <th id="celda-principal">Identificación</th>
            <th id="celda-principal">Nombre</th>
            <th id="celda-principal">Apellido</th>
            <th id="celda-principal">Teléfono</th>
            <th id="celda-principal">Dirección</th>
            <th id="celda-principal">Estado</th>
            <th id="celda-principal">Acciones</th>
        </tr>';
        foreach ($rows as $row) {
            $id = (int)$row['idCliente'];
            $html .= '<tr>
                <td>' . e($row['tipoDocumentoCliente']) . '</td>
                <td>' . e($row['documentoCliente']) . '</td>
                <td>' . e($row['nombresCliente']) . '</td>
                <td>' . e($row['apellidosCliente']) . '</td>
                <td>' . e($row['telefonoCliente']) . '</td>
                <td>' . e($row['direccionCliente']) . '</td>
                <td>' . e($row['estadoCliente']) . '</td>
                <td class="acciones">
                    <a href="' . url('admin/editarCliente/' . $id) . '"><i class="fas fa-edit"></i></a>
                    <form action="' . url('admin/eliminarCliente') . '" method="POST" style="display:inline" onsubmit="return confirm(\'¿Eliminar cliente?\');">
                        <input type="hidden" name="id" value="' . $id . '">
                        <button type="submit"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>';
        }
        echo $html; exit;
    }

    public function editarUsuario($id = null)
    {
        $this->requireAdmin();
        $model = $this->model('Usuario');
        $id = (int)($id ?? ($_POST['id'] ?? 0));

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
            $documento = $_POST['identificacion'] ?? '';
            if ($model->documentoExists($documento, $id)) {
                $error = 'El número de identificación ya está registrado.';
            } else {
                $model->update($id, [
                    'tipoDocumento' => $_POST['tipoDocumento'] ?? '',
                    'documento' => $documento,
                    'nombres' => $_POST['nombre'] ?? '',
                    'apellidos' => $_POST['apellido'] ?? '',
                    'correo' => $_POST['correo'] ?? '',
                    'estado' => $_POST['estado'] ?? 'Activo',
                    'rol' => (int)($_POST['rol'] ?? 3),
                    'clave' => $_POST['nuevaContraseña'] ?? '',
                ]);
                $this->redirect('admin/usuarios');
            }
        }

        $usuario = $model->find($id);
        if (!$usuario) $this->redirect('admin/usuarios');

        $this->view('admin/editar_usuario', $this->adminData([
            'title' => 'Editar usuario',
            'usuario' => $usuario,
            'error' => $error ?? '',
            'css' => ['css/editarUsuario.css', 'css/footer.css']
        ]));
    }

    public function eliminarUsuario()
    {
        $this->requireAdmin();
        if (isset($_POST['id'])) $this->model('Usuario')->delete((int)$_POST['id']);
        $this->redirect('admin/usuarios');
    }

    public function editarCliente($id = null)
    {
        $this->requireAdmin();
        $model = $this->model('Cliente');
        $id = (int)($id ?? ($_POST['id'] ?? 0));

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
            $documento = $_POST['identificacion'] ?? '';
            if ($model->documentoExists($documento, $id)) {
                $error = 'El número de identificación ya está registrado.';
            } else {
                $model->update($id, [
                    'tipoDocumento' => $_POST['tipoDocumento'] ?? '',
                    'documento' => $documento,
                    'nombres' => $_POST['nombre'] ?? '',
                    'apellidos' => $_POST['apellido'] ?? '',
                    'telefono' => $_POST['telefono'] ?? '',
                    'direccion' => $_POST['direccion'] ?? '',
                    'estado' => $_POST['estado'] ?? 'Activo',
                ]);
                $this->redirect('admin/usuarios');
            }
        }

        $cliente = $model->find($id);
        if (!$cliente) $this->redirect('admin/usuarios');

        $this->view('admin/editar_cliente', $this->adminData([
            'title' => 'Editar cliente',
            'cliente' => $cliente,
            'error' => $error ?? '',
            'css' => ['css/editarUsuario.css', 'css/footer.css']
        ]));
    }

    public function eliminarCliente()
    {
        $this->requireAdmin();
        if (isset($_POST['id'])) $this->model('Cliente')->delete((int)$_POST['id']);
        $this->redirect('admin/usuarios');
    }

    public function proveedores()
    {
        $this->requireStaff();
        $this->view('admin/proveedores', $this->adminData([
            'title' => 'Proveedores',
            'proveedores' => $this->model('Proveedor')->all(),
            'css' => ['css/gestionarFuncionarios.css', 'css/footer.css']
        ]));
    }

    public function buscarProveedor()
    {
        $this->requireStaff();
        $rows = $this->model('Proveedor')->all($_POST['searchTerm'] ?? '');
        $html = '<tr>
            <th id="celda-principal">Identificación</th>
            <th id="celda-principal">Nombre</th>
            <th id="celda-principal">Apellido</th>
            <th id="celda-principal">Teléfono</th>
            <th id="celda-principal">Dirección</th>
            <th id="celda-principal">Correo</th>
            <th id="celda-principal">Acciones</th>
        </tr>';
        foreach ($rows as $row) {
            $id = (int)$row['idProveedor'];
            $html .= '<tr>
                <td>' . e($row['idProveedor']) . '</td>
                <td>' . e($row['nombreProveedor']) . '</td>
                <td>' . e($row['apellidoProveedor']) . '</td>
                <td>' . e($row['telefonoProveedor']) . '</td>
                <td>' . e($row['direccionProveedor']) . '</td>
                <td>' . e($row['correoProveedor']) . '</td>
                <td class="acciones">
                    <a href="' . url('admin/editarProveedor/' . $id) . '"><i class="fas fa-edit"></i></a>
                    <form action="' . url('admin/eliminarProveedor') . '" method="POST" style="display:inline" onsubmit="return confirm(\'¿Eliminar proveedor?\');">
                        <input type="hidden" name="id" value="' . $id . '">
                        <button type="submit"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>';
        }
        echo $html; exit;
    }

    public function editarProveedor($id = null)
    {
        $this->requireStaff();
        $model = $this->model('Proveedor');
        $id = (int)($id ?? ($_POST['id'] ?? 0));

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
            $model->update($id, [
                'nombre' => $_POST['nombreProveedor'] ?? '',
                'apellido' => $_POST['apellidoProveedor'] ?? '',
                'telefono' => $_POST['telefonoProveedor'] ?? '',
                'direccion' => $_POST['direccionProveedor'] ?? '',
                'correo' => $_POST['correoProveedor'] ?? '',
            ]);
            $this->redirect('admin/proveedores');
        }

        $proveedor = $model->find($id);
        if (!$proveedor) $this->redirect('admin/proveedores');

        $this->view('admin/editar_proveedor', $this->adminData([
            'title' => 'Editar proveedor',
            'proveedor' => $proveedor,
            'css' => ['css/editarUsuario.css', 'css/footer.css']
        ]));
    }

    public function eliminarProveedor()
    {
        $this->requireStaff();
        if (isset($_POST['id'])) $this->model('Proveedor')->delete((int)$_POST['id']);
        $this->redirect('admin/proveedores');
    }

    public function ventas()
    {
        $this->requireStaff();
        $ventaModel = $this->model('Venta');
        $productoModel = $this->model('Producto');
        $clienteModel = $this->model('Cliente');
        $categoriaModel = $this->model('Categoria');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['documentoCliente']) && !isset($_POST['guardar'])) {
            $this->json($clienteModel->findByDocumento($_POST['documentoCliente']));
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigoProducto']) && !isset($_POST['guardar'])) {
            $this->json($productoModel->findByCodigo($_POST['codigoProducto']));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
            $codigo = $_POST['id'] ?? '';
            $cantidad = (int)($_POST['cantidad'] ?? 0);
            $prod = $productoModel->findByCodigo($codigo);
            if (!$prod) {
                $this->json(['success' => false, 'message' => 'Producto no encontrado']);
            }
            if ((int)$prod['stockProducto'] < $cantidad) {
                $this->json(['success' => false, 'message' => 'No hay suficiente stock']);
            }
            $categorias = $categoriaModel->map();
            $catId = $_POST['categoria'] ?? '';
            $catNombre = $categorias[$catId] ?? ($prod['nombreCategoria'] ?? $catId);

            $ok = $ventaModel->create([
                'codigo' => $codigo,
                'producto' => $_POST['producto'] ?? $prod['nombreProductos'],
                'precio' => (float)($_POST['precio'] ?? $prod['valorProducto']),
                'cantidad' => $cantidad,
                'descripcion' => $_POST['descripcion'] ?? $prod['descripcionProducto'],
                'categoria' => $catNombre,
            ]);
            if ($ok) {
                $productoModel->restarStock($codigo, $cantidad);
                $this->json(['success' => true, 'message' => '¡Datos guardados exitosamente!']);
            }
            $this->json(['success' => false, 'message' => 'Error al guardar la venta']);
        }

        $this->view('admin/ventas', $this->adminData([
            'title' => 'Ventas',
            'ventas' => $ventaModel->all(),
            'categorias' => $categoriaModel->all(),
            'css' => ['css/inventario.css', 'css/ventas.css', 'css/footer.css']
        ]));
    }

    public function buscarVenta()
    {
        $this->requireStaff();
        $rows = $this->model('Venta')->all($_POST['searchTerm'] ?? '');
        $html = '<tr>
            <th id="celda-principal">ID Venta</th>
            <th id="celda-principal">Fecha</th>
            <th id="celda-principal">ID producto</th>
            <th id="celda-principal">Producto</th>
            <th id="celda-principal">Descripción</th>
            <th id="celda-principal">Cantidad</th>
            <th id="celda-principal">Precio Unitario</th>
            <th id="celda-principal">Totales</th>
            <th id="celda-principal">Acciones</th>
        </tr>';
        $total = 0;
        foreach ($rows as $row) {
            $id = (int)$row['idVenta'];
            $sub = (float)$row['cantidad'] * (float)$row['precio_unitario'];
            $total += $sub;
            $html .= '<tr>
                <td>' . e($row['idVenta']) . '</td>
                <td>' . e($row['fecha_venta'] ?? '') . '</td>
                <td>' . e($row['idcodigo']) . '</td>
                <td>' . e($row['producto']) . '</td>
                <td>' . e($row['descripcion']) . '</td>
                <td>' . e($row['cantidad']) . '</td>
                <td>' . e($row['precio_unitario']) . '</td>
                <td>' . e($sub) . '</td>
                <td class="acciones">
                    <a href="' . url('admin/editarVenta/' . $id) . '"><i class="fas fa-edit"></i></a>
                    <form action="' . url('admin/eliminarVenta') . '" method="POST" style="display:inline" onsubmit="return confirm(\'¿Eliminar venta?\');">
                        <input type="hidden" name="id" value="' . $id . '">
                        <button type="submit"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>';
        }
        $html .= '<tr><td colspan="6"></td><td>Total: ' . e($total) . '</td><td></td></tr>';
        echo $html; exit;
    }

    public function editarVenta($id = null)
    {
        $this->requireStaff();
        $model = $this->model('Venta');
        $id = (int)($id ?? ($_POST['id'] ?? 0));

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
            $model->update($id, [
                'codigo' => $_POST['codigo'] ?? '',
                'producto' => $_POST['producto'] ?? '',
                'precio' => (float)($_POST['precio'] ?? 0),
                'cantidad' => (int)($_POST['cantidad'] ?? 0),
                'descripcion' => $_POST['descripcion'] ?? '',
                'categoria' => $_POST['categoria'] ?? '',
            ]);
            $this->redirect('admin/ventas');
        }

        $venta = $model->find($id);
        if (!$venta) $this->redirect('admin/ventas');

        $this->view('admin/editar_venta', $this->adminData([
            'title' => 'Editar venta',
            'venta' => $venta,
            'css' => ['css/editar.css', 'css/footer.css']
        ]));
    }

    public function eliminarVenta()
    {
        $this->requireStaff();
        if (isset($_POST['id'])) $this->model('Venta')->delete((int)$_POST['id']);
        $this->redirect('admin/ventas');
    }

    public function compras()
    {
        $this->requireStaff();
        $search = $_GET['buscar'] ?? '';
        $compras = $this->model('Compra')->allConDetalle($search);
        $this->view('admin/compras', $this->adminData([
            'title' => 'Compras carrito',
            'compras' => $compras,
            'buscar' => $search,
            'css' => ['css/peticiones.css', 'css/footer.css']
        ]));
    }

    public function peticiones()
    {
        $this->requireStaff();
        $model = $this->model('Peticion');
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['estado']) && is_array($_POST['estado'])) {
            foreach ($_POST['estado'] as $correo => $estado) {
                $model->updateEstado($correo, $estado);
            }
            $this->redirect('admin/peticiones');
        }
        $this->view('admin/peticiones', $this->adminData([
            'title' => 'Peticiones',
            'peticiones' => $model->all(),
            'css' => ['css/peticiones.css', 'css/footer.css']
        ]));
    }

    public function actualizarFoto()
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $foto = trim($_POST['foto'] ?? '');
            if ($foto !== '') {
                $this->model('Usuario')->updateFoto($_SESSION['correo'], $foto);
            }
        }
        $this->redirect('admin/index');
    }

    public function reporteInventario()
    {
        $this->requireStaff();
        $productos = $this->model('Producto')->all();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=inventario.csv');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Codigo', 'Producto', 'Precio', 'Stock', 'Descripcion', 'Categoria']);
        foreach ($productos as $p) {
            fputcsv($out, [
                $p['codigoProducto'], $p['nombreProductos'], $p['valorProducto'],
                $p['stockProducto'], $p['descripcionProducto'], $p['nombreCategoria']
            ]);
        }
        fclose($out);
        exit;
    }

    public function reporteVentas()
    {
        $this->requireStaff();
        $ventas = $this->model('Venta')->all();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=ventas.csv');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID', 'Fecha', 'Codigo', 'Producto', 'Cantidad', 'Precio', 'Total']);
        foreach ($ventas as $v) {
            $total = (float)$v['cantidad'] * (float)$v['precio_unitario'];
            fputcsv($out, [
                $v['idVenta'], $v['fecha_venta'] ?? '', $v['idcodigo'],
                $v['producto'], $v['cantidad'], $v['precio_unitario'], $total
            ]);
        }
        fclose($out);
        exit;
    }
}
