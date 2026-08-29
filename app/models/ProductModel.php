<?php

require_once __DIR__ . '/../config/database.php';

class ProductModel
{
    public function getAllProducts(): array
    {
        $conn = db();
        $sql = 'SELECT * FROM productos';
        $result = mysqli_query($conn, $sql);

        $products = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $products[] = $row;
            }
        }

        return $products;
    }
}
