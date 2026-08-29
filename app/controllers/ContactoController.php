<?php
class ContactoController extends Controller
{
    public function index()
    {
        $mensaje = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'direccion' => trim($_POST['direccion'] ?? ''),
                'telefono' => (int)preg_replace('/\D+/', '', $_POST['telefono'] ?? '0'),
                'correo' => trim($_POST['correo'] ?? ''),
                'motivo' => trim($_POST['motivo'] ?? ''),
            ];
            if ($data['nombre'] === '' || $data['apellido'] === '' || $data['correo'] === '' || $data['motivo'] === '') {
                $mensaje = 'Error: completa los campos obligatorios.';
            } else {
                $ok = $this->model('Peticion')->create($data);
                $mensaje = $ok ? 'Petición enviada correctamente.' : 'Error al enviar la petición.';
            }
        }
        $this->view('home/contacto', [
            'title' => 'Contacto / PQRS',
            'mensaje' => $mensaje,
            'css' => ['css/menu.css', 'css/footer.css', 'css/cliente.css']
        ]);
    }
}
