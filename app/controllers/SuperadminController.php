<?php
class SuperadminController extends Controller
{
    public function index()
    {
        $this->requireSuperadmin();
        $tenantModel = $this->model('Tenant');
        $tenants = $tenantModel->allWithStats();
        $totalProductos = 0;
        $totalVentas = 0;
        $tenantsActivos = 0;
        foreach ($tenants as &$tenant) {
            $tenant['totalProductos'] = (int)$tenant['totalProductos'];
            $tenant['totalVentas'] = (float)$tenant['totalVentas'];
            $totalProductos += $tenant['totalProductos'];
            $totalVentas += $tenant['totalVentas'];
            $tenantsActivos += $tenant['estado'] === 'Activo' ? 1 : 0;
        }
        unset($tenant);
        $this->view('superadmin/index', [
            'title' => 'Panel Superadmin',
            'tenants' => $tenants,
            'totalProductos' => $totalProductos,
            'totalVentas' => $totalVentas,
            'tenantsActivos' => $tenantsActivos,
            'css' => ['css/superadmin.css']
        ]);
    }

    public function tenants()
    {
        $this->requireSuperadmin();
        $search = $_GET['q'] ?? '';
        $tenantModel = $this->model('Tenant');
        if ($search) {
            $tenants = $tenantModel->allWithStats();
            $tenants = array_filter($tenants, function ($t) use ($search) {
                return stripos($t['nombre'], $search) !== false ||
                       stripos($t['slug'], $search) !== false ||
                       stripos($t['administradores'] ?? '', $search) !== false;
            });
        } else {
            $tenants = $tenantModel->allWithStats();
        }
        $this->view('superadmin/tenants', [
            'title' => 'Gestión de Ferreterías',
            'tenants' => $tenants,
            'mensaje' => $_SESSION['superadmin_flash'] ?? '',
            'css' => ['css/superadmin.css']
        ]);
        unset($_SESSION['superadmin_flash']);
    }

    public function crear()
    {
        $this->requireSuperadmin();
        $this->view('superadmin/crear', [
            'title' => 'Crear Ferretería',
            'mensaje' => $_SESSION['superadmin_flash'] ?? '',
            'formData' => $_SESSION['superadmin_form'] ?? [],
            'css' => ['css/superadmin.css']
        ]);
        unset($_SESSION['superadmin_flash'], $_SESSION['superadmin_form']);
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
        $formData = array_merge($data, [
            'admin_tipo_documento' => $admin['tipoDocumento'],
            'admin_documento' => $admin['documento'],
            'admin_nombres' => $admin['nombres'],
            'admin_apellidos' => $admin['apellidos'],
            'admin_correo' => $admin['correo'],
            'admin_estado' => $admin['estado'],
        ]);
        $error = '';
        if (
            $data['nombre'] === '' ||
            !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $data['slug']) ||
            $admin['documento'] === '' ||
            !ctype_digit($admin['documento']) ||
            $admin['nombres'] === '' ||
            $admin['apellidos'] === '' ||
            !filter_var($admin['correo'], FILTER_VALIDATE_EMAIL) ||
            strlen($admin['clave']) < 12
        ) {
            $error = 'Revisa los datos: completa los campos obligatorios, usa un slug válido y una contraseña de al menos 12 caracteres.';
        }
        if ($error === '' && (!in_array($data['estado'], ['Activo', 'Inactivo'], true) || !in_array($admin['tipoDocumento'], ['CC', 'TI', 'CE'], true))) {
            $error = 'Selecciona un estado y tipo de documento válidos.';
        }
        $tenantModel = $this->model('Tenant');
        $usuarioModel = $this->model('Usuario');
        if ($error === '' && $tenantModel->findBySlug($data['slug'])) {
            $error = 'Ese slug ya está asignado a otra ferretería.';
        } elseif ($error === '' && $usuarioModel->findByCorreo($admin['correo'])) {
            $error = 'Ese correo ya tiene una cuenta en la plataforma.';
        }
        if ($error !== '') {
            $this->view('superadmin/crear', [
                'title' => 'Crear Ferretería',
                'mensaje' => $error,
                'formData' => $formData,
                'css' => ['css/superadmin.css']
            ]);
            return;
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
            $this->view('superadmin/crear', [
                'title' => 'Crear Ferretería',
                'mensaje' => 'No fue posible guardar la ferretería y su administrador. Verifica los datos e inténtalo de nuevo.',
                'formData' => $formData,
                'css' => ['css/superadmin.css']
            ]);
            return;
        }
        $_SESSION['superadmin_flash'] = 'Ferretería y cuenta administradora creadas correctamente. El administrador ya puede iniciar sesión y cargar productos.';
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
