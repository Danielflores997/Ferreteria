<?php

require_once __DIR__ . '/../config/database.php';

class DashboardModel
{
    public function totals(): array
    {
        $conn = db();

        $totals = [
            'productos' => 0,
            'usuarios' => 0,
            'proveedores' => 0,
            'ventas' => 0,
        ];

        $queries = [
            'productos' => 'SELECT COUNT(*) AS total FROM productos',
            'usuarios' => 'SELECT COUNT(*) AS total FROM usuario',
            'proveedores' => 'SELECT COUNT(*) AS total FROM proveedor',
            'ventas' => 'SELECT COUNT(*) AS total FROM venta',
        ];

        foreach ($queries as $key => $query) {
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $totals[$key] = (int)($row['total'] ?? 0);
            }
        }

        return $totals;
    }
}
