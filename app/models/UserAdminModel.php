<?php

require_once __DIR__ . '/../config/database.php';

class UserAdminModel
{
    public function getAllUsers(): array
    {
        $conn = db();
        $query = 'SELECT * FROM usuario ORDER BY idUsuario ASC';
        $result = mysqli_query($conn, $query);

        $users = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = $row;
            }
        }

        return $users;
    }
}
