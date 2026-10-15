<?php

require_once __DIR__ . '/../models/SaleModel.php';

class SaleController
{
    public function byCategory(): void
    {
        $categoria = $_GET['categoria'] ?? 1;
        $model = new SaleModel();
        $products = $model->getProductsByCategory((string) $categoria);

        require __DIR__ . '/../views/sales/category.php';
    }

    public function cart(): void
    {
        require __DIR__ . '/../views/sales/cart.php';
    }
}
