<?php

require_once __DIR__ . '/../config/database.php';

class SaleModel
{
    public function getProductsByCategory(string $categoria): array
    {
        $conn = db();
        $sql = 'SELECT * FROM productos WHERE nombreCategoria = ?';
        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            return [];
        }

        mysqli_stmt_bind_param($stmt, 'i', $categoria);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $products = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $products[] = $row;
            }
        }

        return $products;
    }
}
