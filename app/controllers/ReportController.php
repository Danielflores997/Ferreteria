<?php

require_once __DIR__ . '/../config/database.php';

class ReportController
{
    public function inventory(): void
    {
        session_start();

        if (!isset($_SESSION['correo'])) {
            header('Location: ../public/login.php');
            exit();
        }

        $conn = db();
        $result = mysqli_query($conn, 'SELECT * FROM productos ORDER BY idProducto ASC');
        $products = [];

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $products[] = $row;
            }
        }

        require __DIR__ . '/../views/reports/inventory.php';
    }
}
