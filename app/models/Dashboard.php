<?php
class Dashboard extends Model
{
    private function scalar($sql, $tenantId = null)
    {
        $stmt = $this->db->prepare($sql);
        if ($tenantId !== null) {
            $stmt->bind_param('i', $tenantId);
        }
        $stmt->execute();
        $row = $stmt->get_result()->fetch_row();
        return $row[0] ?? 0;
    }

    public function totals($tenantId = null)
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
            $where = $tenantId !== null ? ' WHERE tenant_id = ?' : '';
            $totals[$key] = (int)$this->scalar("SELECT COUNT(*) FROM `{$table}`{$where}", $tenantId);
        }

        $where = $tenantId !== null ? ' WHERE tenant_id = ?' : '';
        $totals['stock'] = (int)$this->scalar("SELECT COALESCE(SUM(stockProducto), 0) FROM productos{$where}", $tenantId);
        $totals['bajo_stock'] = (int)$this->scalar(
            'SELECT COUNT(*) FROM productos WHERE stockProducto < 10' .
            ($tenantId !== null ? ' AND tenant_id = ?' : ''),
            $tenantId
        );
        $totals['monto_ventas'] = (float)$this->scalar(
            'SELECT COALESCE(SUM(precio_unitario * cantidad), 0) FROM ventas' . $where,
            $tenantId
        );
        return $totals;
    }

    public function recientes($tenantId = null)
    {
        $out = ['ventas' => [], 'productos' => [], 'peticiones' => []];
        $queries = [
            'ventas' => ['SELECT * FROM ventas', 'idVenta DESC'],
            'productos' => ['SELECT * FROM productos', 'idProducto DESC'],
            'peticiones' => ['SELECT * FROM peticiones', 'idPeticion DESC'],
        ];
        foreach ($queries as $key => [$base, $order]) {
            $sql = $base . ($tenantId !== null ? ' WHERE tenant_id = ?' : '') . " ORDER BY {$order} LIMIT 5";
            $stmt = $this->db->prepare($sql);
            if ($tenantId !== null) {
                $stmt->bind_param('i', $tenantId);
            }
            $stmt->execute();
            $out[$key] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        return $out;
    }
}
