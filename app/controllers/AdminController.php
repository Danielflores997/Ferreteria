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
        $items = [
            ['label' => 'Inicio / Dashboard', 'url' => 'admin/index'],
            ['label' => 'Gestión Catálogo e Inventario', 'url' => 'admin/inventario'],
            ['label' => 'Vista catálogo', 'url' => 'admin/catalogo'],
            ['label' => 'Gestionar proveedores', 'url' => 'admin/proveedores'],
            ['label' => 'Ventas', 'url' => 'admin/ventas'],
            ['label' => 'Compras carrito', 'url' => 'admin/compras'],
            ['label' => 'Peticiones', 'url' => 'admin/peticiones'],
            ['label' => 'Reportes', 'url' => 'admin/reportes'],
        ];
        if ((int)($_SESSION['rol'] ?? 0) === 1) {
            array_splice($items, 3, 0, [['label' => 'Gestionar Usuarios', 'url' => 'admin/usuarios']]);
        }
        return $items;
    }

    public function index()
    {
        $this->requireStaff();
        $usuario = $this->model('Usuario')->findByCorreo($_SESSION['correo']);
        $tenantId = tenantId();
        $dashboard = $this->model('Dashboard');
        $this->view('admin/dashboard', $this->adminData([
            'title' => 'Panel Administrador',
            'usuario' => $usuario,
            'totals' => $dashboard->totals($tenantId),
            'recientes' => $dashboard->recientes($tenantId),
            'css' => ADMIN_CSS
        ]));
    }

    public function catalogo()
    {
        $this->requireStaff();
        $tenantId = tenantId();
        $productoModel = $this->model('Producto');
        $productos = $productoModel->allByTenant($tenantId);
        $this->view('admin/catalogo', $this->adminData([
            'title' => 'Catálogo Admin',
            'productos' => $productos,
            'css' => ADMIN_CSS
        ]));
    }

    public function inventario()
    {
        $this->requireStaff();
        $tenantId = tenantId();
        $productoModel = $this->model('Producto');
        $proveedorModel = $this->model('Proveedor');
        $categoriaModel = $this->model('Categoria');

        // AJAX proveedor lookup
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idProveedor']) && !isset($_POST['guardar'])) {
            $prov = $proveedorModel->findByIdTenant($tenantId, (int)$_POST['idProveedor']);
            $this->json($prov);
        }

        $mensaje = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
            $idProv = trim($_POST['idProveedor'] ?? '');
            if ($idProv !== '' && !$proveedorModel->exists($idProv, $tenantId)) {
                $proveedorModel->create([
                    'id' => $idProv,
                    'nombre' => $_POST['nombreProveedor'] ?? '',
                    'apellido' => $_POST['apellidoProveedor'] ?? '',
                    'telefono' => $_POST['telefonoProveedor'] ?? '',
                    'direccion' => $_POST['direccionProveedor'] ?? '',
                    'correo' => $_POST['correoProveedor'] ?? '',
                    'tenant_id' => $tenantId,
                ]);
            }

            $codigo = trim($_POST['codigo'] ?? '');
            $cantidad = (int)($_POST['cantidad'] ?? 0);
            $existente = $productoModel->findByCodigo($codigo, $tenantId);
            $catId = $_POST['categoria'] ?? '';

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
                    'categoria' => $catId,
                    'imagen' => $_POST['imagen'] ?? '',
                    'tenant_id' => $tenantId,
                ]);
                $mensaje = 'Nuevo producto agregado correctamente.';
            }
        }

        $this->view('admin/inventario', $this->adminData([
            'title' => 'Inventario',
            'productos' => $productoModel->allByTenant($tenantId),
            'ultimoCodigo' => $productoModel->ultimoCodigo($tenantId),
            'categorias' => $categoriaModel->all(),
            'mensaje' => $mensaje,
            'css' => ADMIN_CSS
        ]));
    }

    public function buscarProducto()
    {
        $this->requireStaff();
        $tenantId = tenantId();
        $term = $_POST['searchTerm'] ?? '';
        $rows = $this->model('Producto')->allByTenant($tenantId, $term);
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
                <td>' . e($row['categoriaNombre'] ?? '') . '</td>
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
        $tenantId = tenantId();
        $productoModel = $this->model('Producto');
        $categoriaModel = $this->model('Categoria');
        $id = (int)($id ?? ($_POST['id'] ?? 0));

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
            $catId = $_POST['categoria'] ?? '';
            $productoModel->update($id, [
                'codigo' => $_POST['codigo'] ?? '',
                'nombre' => $_POST['nombre'] ?? '',
                'precio' => (float)($_POST['valor'] ?? 0),
                'stock' => (int)($_POST['stock'] ?? 0),
                'descripcion' => $_POST['descripcion'] ?? '',
                'categoria' => $catId,
                'imagen' => $_POST['imagen'] ?? '',
                'tenant_id' => $tenantId,
            ]);
            $this->redirect('admin/inventario');
        }

        $producto = $productoModel->findByIdTenant($tenantId, $id);
        if (!$producto) {
            $this->redirect('admin/inventario');
        }

        $this->view('admin/editar_producto', $this->adminData([
            'title' => 'Editar producto',
            'producto' => $producto,
            'categorias' => $categoriaModel->map(),
            'css' => ADMIN_CSS
        ]));
    }

    public function eliminarProducto()
    {
        $this->requireStaff();
        $tenantId = tenantId();
        if (isset($_POST['id'])) {
            $this->model('Producto')->delete($tenantId, (int)$_POST['id']);
        }
        $this->redirect('admin/inventario');
    }

    public function bajoStock()
    {
        $this->requireStaff();
        $tenantId = tenantId();
        $this->json($this->model('Producto')->bajoStock($tenantId));
    }

    public function usuarios()
    {
        $this->requireAdmin();
        $tenantId = tenantId();
        $this->view('admin/usuarios', $this->adminData([
            'title' => 'Gestionar Usuarios',
            'usuarios' => $this->model('Usuario')->allByTenant($tenantId),
            'clientes' => $this->model('Cliente')->allByTenant($tenantId),
            'css' => ADMIN_CSS
        ]));
    }

    public function buscarUsuario()
    {
        $this->requireAdmin();
        $tenantId = tenantId();
        $rows = $this->model('Usuario')->allByTenant($tenantId, $_POST['searchTerm'] ?? '');
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
        $tenantId = tenantId();
        $rows = $this->model('Cliente')->allByTenant($tenantId, $_POST['searchTerm'] ?? '');
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
        echo $html;
        exit;
    }
    public function editarUsuario($id = null)
    {
        $this->requireAdmin();
        $tenantId = tenantId();
        $model = $this->model('Usuario');
        $id = (int)($id ?? ($_POST['id'] ?? 0));

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
            $documento = $_POST['identificacion'] ?? '';
            $correo = trim($_POST['correo'] ?? '');
            $rol = (int)($_POST['rol'] ?? 3);
            if ($model->documentoExists($documento, $id, $tenantId)) {
                $error = 'El número de identificación ya está registrado.';
            } elseif ($model->correoExists($correo, $id)) {
                $error = 'El correo ya está registrado en la plataforma.';
            } elseif (!in_array($rol, [1, 2, 3], true)) {
                $error = 'El rol seleccionado no es válido.';
            } elseif (!empty($_POST['clave']) && strlen($_POST['clave']) < 12) {
                $error = 'La contraseña debe tener al menos 12 caracteres.';
            } else {
                $model->update($id, [
                    'tipoDocumento' => $_POST['tipoDocumento'] ?? '',
                    'documento' => $documento,
                    'nombres' => $_POST['nombre'] ?? '',
                    'apellidos' => $_POST['apellido'] ?? '',
                    'correo' => $correo,
                    'estado' => $_POST['estado'] ?? 'Activo',
                    'rol' => $rol,
                    'tenant_id' => $tenantId,
                ]);
                $this->redirect('admin/usuarios');
            }
        }

        $usuario = $model->findByIdTenant($tenantId, $id);
        if (!$usuario) $this->redirect('admin/usuarios');

        $this->view('admin/editar_usuario', $this->adminData([
            'title' => 'Editar usuario',
            'usuario' => $usuario,
            'error' => $error ?? '',
            'css' => ADMIN_CSS
        ]));
    }

    public function eliminarUsuario()
    {
        $this->requireAdmin();
        $tenantId = tenantId();
        if (isset($_POST['id'])) $this->model('Usuario')->delete($tenantId, (int)$_POST['id']);
        $this->redirect('admin/usuarios');
    }

    public function editarCliente($id = null)
    {
        $this->requireAdmin();
        $tenantId = tenantId();
        $model = $this->model('Cliente');
        $id = (int)($id ?? ($_POST['id'] ?? 0));

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
            $documento = $_POST['identificacion'] ?? '';
            if ($model->documentoExists($documento, $id, $tenantId)) {
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
                    'tenant_id' => $tenantId,
                ]);
                $this->redirect('admin/usuarios');
            }
        }

        $cliente = $model->findByIdTenant($tenantId, $id);
        if (!$cliente) $this->redirect('admin/usuarios');

        $this->view('admin/editar_cliente', $this->adminData([
            'title' => 'Editar cliente',
            'cliente' => $cliente,
            'css' => ADMIN_CSS
        ]));
    }

    public function eliminarCliente()
    {
        $this->requireAdmin();
        $tenantId = tenantId();
        if (isset($_POST['id'])) $this->model('Cliente')->delete($tenantId, (int)$_POST['id']);
        $this->redirect('admin/usuarios');
    }

    public function proveedores()
    {
        $this->requireStaff();
        $tenantId = tenantId();
        $this->view('admin/proveedores', $this->adminData([
            'title' => 'Proveedores',
            'proveedores' => $this->model('Proveedor')->allByTenant($tenantId),
            'css' => ADMIN_CSS
        ]));
    }

public function buscarProveedor()
    {
        $this->requireStaff();
        $tenantId = tenantId();
        $rows = $this->model('Proveedor')->allByTenant($tenantId, $_POST['searchTerm'] ?? '');
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
        $tenantId = tenantId();
        $model = $this->model('Proveedor');
        $id = (int)($id ?? ($_POST['id'] ?? 0));

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
            $model->update($id, [
                'nombre' => $_POST['nombreProveedor'] ?? '',
                'apellido' => $_POST['apellidoProveedor'] ?? '',
                'telefono' => $_POST['telefonoProveedor'] ?? '',
                'direccion' => $_POST['direccionProveedor'] ?? '',
                'correo' => $_POST['correoProveedor'] ?? '',
                'tenant_id' => $tenantId,
            ]);
            $this->redirect('admin/proveedores');
        }

        $proveedor = $model->findByIdTenant($tenantId, $id);
        if (!$proveedor) $this->redirect('admin/proveedores');

        $this->view('admin/editar_proveedor', $this->adminData([
            'title' => 'Editar proveedor',
            'proveedor' => $proveedor,
            'css' => ADMIN_CSS
        ]));
    }

    public function eliminarProveedor()
    {
        $this->requireStaff();
        $tenantId = tenantId();
        if (isset($_POST['id'])) $this->model('Proveedor')->delete($tenantId, (int)$_POST['id']);
        $this->redirect('admin/proveedores');
    }

    public function ventas()
    {
        $this->requireStaff();
        $tenantId = tenantId();
        $ventaModel = $this->model('Venta');
        $productoModel = $this->model('Producto');
        $clienteModel = $this->model('Cliente');
        $categoriaModel = $this->model('Categoria');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['documentoCliente']) && !isset($_POST['guardar'])) {
            $this->json($clienteModel->findByDocumento($_POST['documentoCliente'], $tenantId));
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigoProducto']) && !isset($_POST['guardar'])) {
            $this->json($productoModel->findByCodigoTenant($_POST['codigoProducto'], $tenantId));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
            $codigo = $_POST['id'] ?? '';
            $cantidad = (int)($_POST['cantidad'] ?? 0);
            $prod = $productoModel->findByCodigoTenant($codigo, $tenantId);
            if (!$prod) {
                $this->json(['success' => false, 'message' => 'Producto no encontrado']);
            }
            if ($cantidad <= 0) {
                $this->json(['success' => false, 'message' => 'La cantidad debe ser mayor a cero'], 422);
            }
            if ((int)$prod['stockProducto'] < $cantidad) {
                $this->json(['success' => false, 'message' => 'No hay suficiente stock']);
            }
            $categorias = $categoriaModel->map();
            $catId = $_POST['categoria'] ?? '';
            $catNombre = $categorias[$catId] ?? ($prod['categoriaNombre'] ?? $catId);

            $db = Database::getInstance()->getConnection();
            $db->begin_transaction();
            try {
                if (!$productoModel->restarStock($codigo, $cantidad, $tenantId)) {
                    $db->rollback();
                    $this->json(['success' => false, 'message' => 'No hay suficiente stock']);
                }
                $ok = $ventaModel->create([
                    'codigo' => $codigo,
                    'producto' => $prod['nombreProductos'],
                    'precio' => $prod['valorProducto'],
                    'cantidad' => $cantidad,
                    'descripcion' => $prod['descripcionProducto'],
                    'categoria' => $catNombre,
                    'tenant_id' => $tenantId,
                ]);
                if (!$ok) {
                    throw new RuntimeException('No se pudo registrar la venta.');
                }
                $db->commit();
                $this->json(['success' => true, 'message' => '¡Datos guardados exitosamente!']);
            } catch (mysqli_sql_exception | RuntimeException $e) {
                $db->rollback();
                error_log('Error al registrar venta: ' . $e->getMessage());
                $this->json(['success' => false, 'message' => 'Error al guardar la venta'], 500);
            }
        }

        $this->view('admin/ventas', $this->adminData([
            'title' => 'Ventas',
            'ventas' => $ventaModel->allByTenant($tenantId),
            'categorias' => $categoriaModel->all(),
            'css' => ADMIN_CSS
        ]));
    }

public function buscarVenta()
    {
        $this->requireStaff();
        $tenantId = tenantId();
        $rows = $this->model('Venta')->allByTenant($tenantId, $_POST['searchTerm'] ?? '');
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
                <td>' . e($row['fecha_venta']) . '</td>
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
        $tenantId = tenantId();
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
                'tenant_id' => $tenantId,
            ]);
            $this->redirect('admin/ventas');
        }

        $venta = $model->findByIdTenant($tenantId, $id);
        if (!$venta) $this->redirect('admin/ventas');

        $this->view('admin/editar_venta', $this->adminData([
            'title' => 'Editar venta',
            'venta' => $venta,
            'css' => ADMIN_CSS
        ]));
    }

    public function eliminarVenta()
    {
        $this->requireStaff();
        $tenantId = tenantId();
        if (isset($_POST['id'])) $this->model('Venta')->delete($tenantId, (int)$_POST['id']);
        $this->redirect('admin/ventas');
    }

    public function compras()
    {
        $this->requireStaff();
        $tenantId = tenantId();
        $search = $_GET['buscar'] ?? '';
        $compras = $this->model('Compra')->allConDetalle($tenantId, $search);
        $this->view('admin/compras', $this->adminData([
            'title' => 'Compras carrito',
            'compras' => $compras,
            'buscar' => $search,
            'css' => ADMIN_CSS
        ]));
    }

    public function peticiones()
    {
        $this->requireStaff();
        $tenantId = tenantId();
        $this->view('admin/peticiones', $this->adminData([
            'title' => 'Peticiones',
            'peticiones' => $this->model('Peticion')->allByTenant($tenantId),
            'css' => ADMIN_CSS
        ]));
    }

    public function actualizarFoto()
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioModel = $this->model('Usuario');

            if (isset($_POST['quitar'])) {
                $usuarioModel->updateFoto($_SESSION['correo'], '');
                $this->redirect('admin/index');
            }

            $subida = $this->guardarFotoSubida('archivo');
            $foto = $subida ?? trim($_POST['foto'] ?? '');
            if ($foto !== '') {
                $usuarioModel->updateFoto($_SESSION['correo'], $foto);
            }
        }
        $this->redirect('admin/index');
    }

    public function reporteInventario()
    {
        $this->requireStaff();
        $productos = $this->model('Producto')->allByTenant(tenantId());
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=inventario.csv');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Codigo', 'Producto', 'Precio', 'Stock', 'Descripcion', 'Categoria']);
        foreach ($productos as $p) {
            fputcsv($out, [
                $p['codigoProducto'], $p['nombreProductos'], $p['valorProducto'],
                $p['stockProducto'], $p['descripcionProducto'], $p['categoriaNombre'] ?? ''
            ]);
        }
        fclose($out);
        exit;
    }

    public function reporteVentas()
    {
        $this->requireStaff();
        $ventas = $this->model('Venta')->allByTenant(tenantId());
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


    public function crearUsuario()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = $this->model('Usuario');
            $documento = trim($_POST['documento'] ?? '');
            $correo = trim($_POST['correo'] ?? '');
            $password = $_POST['clave'] ?? '';
            $tenantId = tenantId();
            $rol = (int)($_POST['rol'] ?? 3);
            if (
                $tenantId !== null &&
                $documento !== '' &&
                ctype_digit($documento) &&
                filter_var($correo, FILTER_VALIDATE_EMAIL) &&
                strlen($password) >= 12 &&
                in_array($rol, [1, 2, 3], true) &&
                !$model->documentoExists($documento, null, $tenantId) &&
                !$model->correoExists($correo)
            ) {
                $model->registrarAdmin([
                    'tipoDocumento' => $_POST['tipoDocumento'] ?? 'CC',
                    'documento' => $documento,
                    'nombres' => $_POST['nombres'] ?? '',
                    'apellidos' => $_POST['apellidos'] ?? '',
                    'correo' => $correo,
                    'clave' => $password,
                    'estado' => $_POST['estado'] ?? 'Activo',
                    'rol' => $rol,
                    'tenant_id' => $tenantId,
                ]);
            }
        }
        $this->redirect('admin/usuarios');
    }

    public function reportes()
    {
        $this->requireStaff();
        $dashboard = $this->model('Dashboard');
        $this->view('admin/reportes', $this->adminData([
            'title' => 'Reportes',
            'totals' => $dashboard->totals(tenantId()),
            'productos' => $this->model('Producto')->allByTenant(tenantId()),
            'ventas' => $this->model('Venta')->allByTenant(tenantId()),
            'css' => ADMIN_CSS
        ]));
    }

    public function reporteInventarioHtml()
    {
        $this->requireStaff();
        $this->view('admin/reporte_inventario', $this->adminData([
            'title' => 'Reporte Inventario',
            'productos' => $this->model('Producto')->allByTenant(tenantId()),
            'css' => ADMIN_CSS
        ]));
    }

    public function reporteVentasHtml()
    {
        $this->requireStaff();
        $this->view('admin/reporte_ventas', $this->adminData([
            'title' => 'Reporte Ventas',
            'ventas' => $this->model('Venta')->allByTenant(tenantId()),
            'css' => ADMIN_CSS
        ]));
    }
}
