<?php
class SuperadminController extends Controller
{
    public function index()
    {
        $this->requireSuperadmin();
        $tenantModel = $this->model('Tenant');
        $tenants = $tenantModel->all();
        $totalProductos = 0;
        $totalVentas = 0;
        foreach ($tenants as $t) {
            $p = $this->model('Producto')->allByTenant($t['id']);
            $totalProductos += count($p);
            $v = $this->model('Venta')->allByTenant($t['id']);
            foreach ($v as $venta) {
                $totalVentas += (float)$venta['precio_unitario'] * (int)$venta['cantidad'];
            }
        }
        $this->view('superadmin/index', [
            'title' => 'Panel Superadmin',
            'tenants' => $tenants,
            'totalProductos' => $totalProductos,
            'totalVentas' => $totalVentas,
            'css' => ['css/superadmin.css']
        ]);
    }

    public function tenants()
    {
        $this->requireSuperadmin();
        $search = $_GET['q'] ?? '';
        $tenantModel = $this->model('Tenant');
        if ($search) {
            $tenants = $tenantModel->all();
            $tenants = array_filter($tenants, function ($t) use ($search) {
                return stripos($t['nombre'], $search) !== false ||
                       stripos($t['slug'], $search) !== false;
            });
        } else {
            $tenants = $tenantModel->all();
        }
        $this->view('superadmin/tenants', [
            'title' => 'Gestión de Ferreterías',
            'tenants' => $tenants,
            'css' => ['css/superadmin.css']
        ]);
    }

    public function crear()
    {
        $this->requireSuperadmin();
        $this->view('superadmin/crear', [
            'title' => 'Crear Ferretería',
            'css' => ['css/superadmin.css']
        ]);
    }

    public function store()
    {
        $this->requireSuperadmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('superadmin/crear');
        }
        $admin = [
            'tipoDocumento' => $_POST['admin_tipo_documento'] ?? 'CC',
            'documento' => trim($_POST['admin_documento'] ?? ''),
            'nombres' => trim($_POST['admin_nombres'] ?? ''),
            'apellidos' => trim($_POST['admin_apellidos'] ?? ''),
            'correo' => trim($_POST['admin_correo'] ?? ''),
            'clave' => $_POST['admin_clave'] ?? '',
            'estado' => 'Activo',
            'rol' => 1,
        ];
        $data = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'documento' => $_POST['documento'] ?? '',
            'correo' => $_POST['correo'] ?? '',
            'telefono' => $_POST['telefono'] ?? '',
            'direccion' => $_POST['direccion'] ?? '',
            'logo' => $_POST['logo'] ?? '',
            'estado' => $_POST['estado'] ?? 'Activo',
        ];
        if (
            $data['nombre'] === '' ||
            !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $data['slug']) ||
            $admin['documento'] === '' ||
            $admin['nombres'] === '' ||
            $admin['apellidos'] === '' ||
            !filter_var($admin['correo'], FILTER_VALIDATE_EMAIL) ||
            strlen($admin['clave']) < 12
        ) {
            $this->redirect('superadmin/crear');
        }
        if (!in_array($data['estado'], ['Activo', 'Inactivo'], true) || !in_array($admin['tipoDocumento'], ['CC', 'TI', 'CE'], true)) {
            $this->redirect('superadmin/crear');
        }
        $tenantModel = $this->model('Tenant');
        $usuarioModel = $this->model('Usuario');
        if ($tenantModel->findBySlug($data['slug']) || $usuarioModel->findByCorreo($admin['correo'])) {
            $this->redirect('superadmin/crear');
        }
        $db = Database::getInstance()->getConnection();
        $db->begin_transaction();
        try {
            $tenantId = $tenantModel->create($data);
            $admin['tenant_id'] = $tenantId;
            if (!$usuarioModel->registrarAdmin($admin)) {
                throw new RuntimeException('No se pudo crear el administrador de la ferretería.');
            }
            $db->commit();
        } catch (mysqli_sql_exception | RuntimeException $e) {
            $db->rollback();
            error_log('Tenant creation failed: ' . $e->getMessage());
            $this->redirect('superadmin/crear');
        }
        $this->redirect('superadmin/tenants');
    }

    public function editar($id)
    {
        $this->requireSuperadmin();
        $tenantModel = $this->model('Tenant');
        $tenant = $tenantModel->find($id);
        if (!$tenant) {
            $this->redirect('superadmin/tenants');
        }
        $this->view('superadmin/editar', [
            'title' => 'Editar Ferretería',
            'tenant' => $tenant,
            'css' => ['css/superadmin.css']
        ]);
    }

    public function update($id)
    {
        $this->requireSuperadmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect("superadmin/editar/$id");
        }
        $data = [
            'nombre' => $_POST['nombre'] ?? '',
            'slug' => $_POST['slug'] ?? '',
            'documento' => $_POST['documento'] ?? '',
            'correo' => $_POST['correo'] ?? '',
            'telefono' => $_POST['telefono'] ?? '',
            'direccion' => $_POST['direccion'] ?? '',
            'logo' => $_POST['logo'] ?? '',
            'estado' => $_POST['estado'] ?? 'Activo',
        ];
        if (
            empty($data['nombre']) ||
            !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $data['slug']) ||
            !in_array($data['estado'], ['Activo', 'Inactivo'], true)
        ) {
            $this->redirect("superadmin/editar/$id");
        }
        $exists = $this->model('Tenant')->findBySlug($data['slug']);
        if ($exists && $exists['id'] != $id) {
            $this->redirect("superadmin/editar/$id");
        }
        $this->model('Tenant')->update($id, $data);
        $this->redirect('superadmin/tenants');
    }

    public function cambiarEstado($id)
    {
        $this->requireSuperadmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('superadmin/tenants');
        }
        $tenantModel = $this->model('Tenant');
        $tenant = $tenantModel->find($id);
        if (!$tenant) {
            $this->redirect('superadmin/tenants');
        }
        $nuevo = ($tenant['estado'] === 'Activo') ? 'Inactivo' : 'Activo';
        $this->model('Tenant')->setEstado($id, $nuevo);
        $this->redirect('superadmin/tenants');
    }
}
