<?php

require_once __DIR__ . '/../config/database.php';

class ProviderModel
{
    public function getAllProviders(): array
    {
        $conn = db();
        $query = 'SELECT * FROM proveedor ORDER BY idProveedor ASC';
        $result = mysqli_query($conn, $query);

        $providers = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $providers[] = $row;
            }
        }

        return $providers;
    }

    public function getProviderById(int $id): ?array
    {
        $conn = db();
        $query = 'SELECT * FROM proveedor WHERE idProveedor = ?';
        $stmt = mysqli_prepare($conn, $query);

        if (!$stmt) {
            return null;
        }

        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }

        return null;
    }
}
