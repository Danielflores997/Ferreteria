<?php
class ContactoController extends Controller
{
    public function index()
    {
        $mensaje = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $this->model('Peticion')->create([
                'nombre' => $_POST['nombre'] ?? '',
                'apellido' => $_POST['apellido'] ?? '',
                'direccion' => $_POST['direccion'] ?? '',
                'telefono' => (int)($_POST['telefono'] ?? 0),
                'correo' => $_POST['correo'] ?? '',
                'motivo' => $_POST['motivo'] ?? '',
            ]);
            $mensaje = $ok ? 'Petición enviada correctamente.' : 'Error al enviar la petición.';
        }
        $this->view('home/contacto', [
            'title' => 'Contacto / PQRS',
            'mensaje' => $mensaje,
            'css' => ['css/pqrs.css', 'css/menu.css', 'css/footer.css']
        ]);
    }
}
