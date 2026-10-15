<?php

require_once __DIR__ . '/../config/database.php';

class UserModel
{
    public function login(string $correo, string $password): ?array
    {
        $conn = db();
        $query = 'SELECT * FROM usuario WHERE correo = ? AND claveUsuario = ?';
        $stmt = mysqli_prepare($conn, $query);

        if (!$stmt) {
            return null;
        }

        mysqli_stmt_bind_param($stmt, 'ss', $correo, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }

        return null;
    }
}
