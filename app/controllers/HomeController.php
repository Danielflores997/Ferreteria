<?php
class HomeController extends Controller
{
    private const PRODUCTOS_POR_PAGINA = 20;

    public function index()
    {
        $producto = $this->model('Producto');
        $search = $_GET['q'] ?? '';
        $cat = $_GET['cat'] ?? '';
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = self::PRODUCTOS_POR_PAGINA;
        $offset = ($page - 1) * $limit;

        $data = $producto->marketplace($search, null, $limit, $offset);
        $total = $data['total'];
        $pages = (int)ceil($total / $limit);
        if ($pages > 0 && $page > $pages) {
            $page = $pages;
            $offset = ($page - 1) * $limit;
            $data = $producto->marketplace($search, null, $limit, $offset);
        }

        $this->view('home/index', [
            'title' => 'Catálogo',
            'productos' => $data['rows'],
            'search' => $search,
            'cat' => $cat,
            'page' => $page,
            'pages' => $pages,
            'total' => $total,
            'firstItem' => $total > 0 ? $offset + 1 : 0,
            'lastItem' => min($total, $offset + count($data['rows'])),
            'css' => ['css/index.css', 'css/menu.css', 'css/footer.css', 'css/catalogo-marketplace.css']
        ]);
    }

    public function producto($id = null)
    {
        $producto = $this->model('Producto');
        $id = (is_array($id) ? $id[0] : $id) ?? null;
        $item = $producto->findPublic((int)$id);
        if (!$item) {
            $this->redirect('home/index');
        }
        $similares = $producto->similares($item['idProducto'], 8);
        $this->view('home/producto', [
            'title' => $item['nombreProductos'] ?? 'Producto',
            'producto' => $item,
            'similares' => $similares,
            'css' => ['css/producto.css', 'css/menu.css', 'css/footer.css']
        ]);
    }

    public function nosotros()
    {
        $this->view('home/nosotros', [
            'title' => 'Nosotros',
            'css' => ['css/nosotros.css?v=' . filemtime(PUBLIC_PATH . '/css/nosotros.css'), 'css/menu.css', 'css/footer.css']
        ]);
    }

    public function categoria($slug = '')
    {
        $map = [
            'pinturas' => 'PINTURAS',
            'electricas' => 'HERRAMIENTAS ELECTRICAS',
            'herramientas' => 'HERRAMIENTAS',
            'accesorios' => 'ACCESORIOS',
            'carpinteria' => 'CARPINTERIA',
            'plomeria' => 'PLOMERIA',
            'jardineria' => 'JARDINERIA',
            'cementos' => 'CEMENTOS',
            'tornilleria' => 'TORNILLLERIA',
        ];
        $nombre = $map[$slug] ?? strtoupper($slug);
        $producto = $this->model('Producto');
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = self::PRODUCTOS_POR_PAGINA;
        $data = $producto->byCategoriaNombrePaginado($nombre, $limit, ($page - 1) * $limit);
        $pages = (int)ceil($data['total'] / $limit);
        if ($pages > 0 && $page > $pages) {
            $page = $pages;
            $data = $producto->byCategoriaNombrePaginado($nombre, $limit, ($page - 1) * $limit);
        }
        $offset = ($page - 1) * $limit;
        $this->view('catalogo/categoria', [
            'title' => ucfirst($slug),
            'categoria' => $nombre,
            'slug' => $slug,
            'productos' => $data['rows'],
            'page' => $page,
            'pages' => $pages,
            'total' => $data['total'],
            'firstItem' => $data['total'] > 0 ? $offset + 1 : 0,
            'lastItem' => min($data['total'], $offset + count($data['rows'])),
            'css' => ['css/index.css', 'css/menu.css', 'css/footer.css', 'css/catalogo-marketplace.css']
        ]);
    }
}
