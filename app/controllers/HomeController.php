<?php
class HomeController extends Controller
{
    public function index()
    {
        $producto = $this->model('Producto');
        $this->view('home/index', [
            'title' => 'Catálogo',
            'productos' => $producto->all(),
            'css' => ['css/index.css', 'css/menu.css', 'css/footer.css']
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
