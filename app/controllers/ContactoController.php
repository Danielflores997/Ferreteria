<?php
class ContactoController extends Controller
{
    public function index()
    {
        $mensaje = '';
        $esError = false;
        $formData = [
            'nombre' => '',
            'apellido' => '',
            'telefono' => '',
            'correo' => '',
            'direccion' => '',
            'motivo' => '',
        ];
        $ferreteriasSeleccionadas = [];
        $ferreterias = $this->model('Tenant')->allActive();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($formData as $field => $default) {
                $formData[$field] = trim((string)($_POST[$field] ?? $default));
            }

            $recipientInput = $_POST['ferreterias'] ?? [];
            if (is_array($recipientInput)) {
                foreach ($recipientInput as $recipientId) {
                    if (!is_string($recipientId) && !is_int($recipientId)) {
                        continue;
                    }
                    $validatedId = filter_var(
                        (string)$recipientId,
                        FILTER_VALIDATE_INT,
                        ['options' => ['min_range' => 1]]
                    );
                    if ($validatedId !== false) {
                        $ferreteriasSeleccionadas[] = (int)$validatedId;
                    }
                }
            }
            $ferreteriasSeleccionadas = array_values(array_unique($ferreteriasSeleccionadas));

            $activeIds = array_map(static fn($tenant) => (int)$tenant['id'], $ferreterias);
            if (
                $formData['nombre'] === ''
                || $formData['apellido'] === ''
                || !filter_var($formData['correo'], FILTER_VALIDATE_EMAIL)
                || $formData['motivo'] === ''
            ) {
                $mensaje = 'Completa los campos obligatorios con datos válidos.';
                $esError = true;
            } elseif ($ferreteriasSeleccionadas === []) {
                $mensaje = 'Selecciona al menos una ferretería destinataria.';
                $esError = true;
            } elseif (array_diff($ferreteriasSeleccionadas, $activeIds) !== []) {
                $mensaje = 'Una o más ferreterías seleccionadas ya no están disponibles. Actualiza la página e inténtalo de nuevo.';
                $esError = true;
            } else {
                try {
                    $destinatarios = $this->model('Peticion')->createForTenants($formData, $ferreteriasSeleccionadas);
                    $mensaje = $destinatarios === 1
                        ? 'Petición enviada correctamente a 1 ferretería.'
                        : 'Petición enviada correctamente a ' . $destinatarios . ' ferreterías.';
                    $formData = array_fill_keys(array_keys($formData), '');
                    $ferreteriasSeleccionadas = [];
                } catch (mysqli_sql_exception | RuntimeException $error) {
                    error_log('PQRS submission failed: ' . $error->getMessage());
                    $mensaje = 'No se pudo enviar la petición. Revisa los datos e inténtalo de nuevo.';
                    $esError = true;
                }
            }
        }

        $this->view('home/contacto', [
            'title' => 'Contacto / PQRS',
            'mensaje' => $mensaje,
            'esError' => $esError,
            'formData' => $formData,
            'ferreterias' => $ferreterias,
            'ferreteriasSeleccionadas' => $ferreteriasSeleccionadas,
            'css' => ['css/menu.css', 'css/footer.css', 'css/cliente.css?v=' . filemtime(PUBLIC_PATH . '/css/cliente.css')]
        ]);
    }
}
