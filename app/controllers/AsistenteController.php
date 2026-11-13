<?php
class AsistenteController extends Controller
{
    public function consultar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Método no permitido.'], 405);
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $question = is_array($input) && isset($input['message']) && is_string($input['message'])
            ? trim(strip_tags($input['message']))
            : '';
        if ($question === '' || strlen($question) > 1500 || preg_match('//u', $question) !== 1) {
            $this->json(['success' => false, 'message' => 'Escribe una pregunta de hasta 500 caracteres.'], 422);
        }

        $now = time();
        $recentRequests = array_values(array_filter(
            $_SESSION['assistant_requests'] ?? [],
            static fn($timestamp) => is_int($timestamp) && $timestamp > $now - 60
        ));
        if (count($recentRequests) >= 6) {
            $this->json(['success' => false, 'message' => 'Has enviado varias consultas. Espera un minuto e inténtalo de nuevo.'], 429);
        }
        $recentRequests[] = $now;
        $_SESSION['assistant_requests'] = $recentRequests;

        $products = $this->model('Producto')->assistantCandidates($question);

        require_once APP_PATH . '/services/GeminiAssistant.php';
        try {
            $recommendation = (new GeminiAssistant())->recommend($question, $products);
        } catch (RuntimeException $error) {
            error_log('Asistente Gemini: ' . $error->getMessage());
            $publicMessage = 'El asistente no pudo responder ahora. Puedes continuar usando la búsqueda del catálogo.';
            if (preg_match('/HTTP (502|503|504)\b/', $error->getMessage(), $statusMatch)) {
                $publicMessage = 'Gemini está temporalmente indisponible (HTTP ' . $statusMatch[1] . '). Inténtalo de nuevo en unos segundos.';
            }
            $this->json([
                'success' => false,
                'message' => $publicMessage,
            ], 503);
        }

        $productsById = [];
        foreach ($products as $product) {
            $id = (int)$product['idProducto'];
            $productsById[$id] = [
                'id' => $id,
                'name' => (string)$product['nombreProductos'],
                'category' => (string)($product['categoriaNombre'] ?? ''),
                'price' => (float)$product['valorProducto'],
                'store' => (string)($product['tenantNombre'] ?? ''),
                'image' => productImageUrl($product['imagen'] ?? ''),
                'url' => url('home/producto/' . $id),
            ];
        }

        $recommendations = [];
        foreach ($recommendation['product_ids'] as $id) {
            if (isset($productsById[$id])) {
                $recommendations[] = $productsById[$id];
            }
        }

        $this->json([
            'success' => true,
            'message' => $recommendation['message'],
            'products' => $recommendations,
        ]);
    }
}
