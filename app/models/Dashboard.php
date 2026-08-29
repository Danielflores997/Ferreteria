<?php
class Dashboard extends Model
{
    public function totals()
    {
        $tables = [
            'productos' => 'productos',
            'usuarios' => 'usuario',
            'proveedores' => 'proveedor',
            'ventas' => 'ventas',
            'clientes' => 'cliente',
            'compras' => 'compras',
            'peticiones' => 'peticiones',
        ];
        $totals = [];
        foreach ($tables as $key => $table) {
            $result = $this->db->query("SELECT COUNT(*) AS total FROM `{$table}`");
            $row = $result ? $result->fetch_assoc() : ['total' => 0];
            $totals[$key] = (int)($row['total'] ?? 0);
        }

        $stock = $this->db->query('SELECT COALESCE(SUM(stockProducto),0) AS total FROM productos');
        $totals['stock'] = (int)(($stock ? $stock->fetch_assoc()['total'] : 0));

        $bajo = $this->db->query('SELECT COUNT(*) AS total FROM productos WHERE stockProducto < 10');
        $totals['bajo_stock'] = (int)(($bajo ? $bajo->fetch_assoc()['total'] : 0));

        $ventasMonto = $this->db->query('SELECT COALESCE(SUM(precio_unitario * cantidad),0) AS total FROM ventas');
        $totals['monto_ventas'] = (float)(($ventasMonto ? $ventasMonto->fetch_assoc()['total'] : 0));

        return $totals;
    }

    public function recientes()
    {
        $out = ['ventas' => [], 'productos' => [], 'peticiones' => []];
        $v = $this->db->query('SELECT * FROM ventas ORDER BY idVenta DESC LIMIT 5');
        if ($v) $out['ventas'] = $v->fetch_all(MYSQLI_ASSOC);
        $p = $this->db->query('SELECT * FROM productos ORDER BY idProducto DESC LIMIT 5');
        if ($p) $out['productos'] = $p->fetch_all(MYSQLI_ASSOC);
        $pet = $this->db->query('SELECT * FROM peticiones ORDER BY Correo DESC LIMIT 5');
        if ($pet) $out['peticiones'] = $pet->fetch_all(MYSQLI_ASSOC);
        return $out;
    }
}
