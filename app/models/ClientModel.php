<?php

require_once __DIR__ . '/../config/database.php';

class ClientModel
{
    public function registrarCliente(array $datos, int $tenantId): bool
    {
        $conn = db();

        // 1. Verificar que el documento no exista en ESTE tenant
        $check = mysqli_prepare($conn, 'SELECT idCliente FROM cliente WHERE documentoCliente = ? AND tenant_id = ?');
        mysqli_stmt_bind_param($check, 'si', $datos['documento'], $tenantId);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {
            return false; // Ya existe
        }

        // 2. Insertar en la tabla cliente
        $query = 'INSERT INTO cliente (tipoDocumentoCliente, documentoCliente, nombresCliente, apellidosCliente, telefonoCliente, direccionCliente, estadoCliente, tenant_id) 
                    VALUES (?, ?, ?, ?, ?, ?, "Activo", ?)';

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param(
            $stmt,
            'ssssssi',
            $datos['tipoDocumento'],
            $datos['documento'],
            $datos['nombres'],
            $datos['apellidos'],
            $datos['telefono'],
            $datos['direccion'],
            $tenantId
        );

        return mysqli_stmt_execute($stmt);
    }

    // Método para crear también el usuario de login
    public function registrarUsuario(array $datos, int $tenantId): bool
    {
        $conn = db();

        // Verificar que el correo no exista en este tenant
        $check = mysqli_prepare($conn, 'SELECT idUsuario FROM usuario WHERE correo = ? AND tenant_id = ?');
        mysqli_stmt_bind_param($check, 'si', $datos['correo'], $tenantId);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {
            return false;
        }

        // Insertar usuario con rol 2 (Vendedor/Cliente)
        $query = 'INSERT INTO usuario (tipoDocumentoUsuario, documentoUsuario, nombresUsuario, apellidosUsuario, correo, claveUsuario, estadoUsuario, rol_idRol, tenant_id) 
                    VALUES (?, ?, ?, ?, ?, ?, "Activo", 2, ?)';

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param(
            $stmt,
            'ssssssi',
            $datos['tipoDocumento'],
            $datos['documento'],
            $datos['nombres'],
            $datos['apellidos'],
            $datos['correo'],
            $datos['clave'],
            $tenantId
        );

        return mysqli_stmt_execute($stmt);
    }
}