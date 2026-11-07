<?php
class HomeController extends Controller
{
    public function index()
    {
        $producto = $this->model('Producto');
        $search = $_GET['q'] ?? '';
        $cat = $_GET['cat'] ?? '';
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $data = $producto->marketplace($search, null, $limit, $offset);
        $total = $data['total'];
        $pages = ceil($total / $limit);

        $this->view('home/index', [
            'title' => 'Catálogo',
            'productos' => $data['rows'],
            'search' => $search,
            'cat' => $cat,
            'page' => $page,
            'pages' => $pages,
            'total' => $total,
            'css' => ['css/index.css', 'css/menu.css', 'css/footer.css']
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
            'css' => ['css/nosotros.css', 'css/menu.css', 'css/footer.css']
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
        $this->view('catalogo/categoria', [
            'title' => ucfirst($slug),
            'categoria' => $nombre,
            'productos' => $producto->byCategoriaNombre($nombre),
            'css' => ['css/index.css', 'css/menu.css', 'css/footer.css']
        ]);
    }
}
