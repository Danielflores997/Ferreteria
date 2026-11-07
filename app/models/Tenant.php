<?php
class Tenant extends Model
{
    public static function all()
    {
        $db = Database::getInstance()->getConnection();
        $result = $db->query('SELECT * FROM tenants ORDER BY nombre');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public static function allWithStats()
    {
        $db = Database::getInstance()->getConnection();
        $result = $db->query(
            "SELECT t.*,
                (SELECT COUNT(*) FROM productos p WHERE p.tenant_id = t.id) AS totalProductos,
                (SELECT COALESCE(SUM(v.precio_unitario * v.cantidad), 0) FROM ventas v WHERE v.tenant_id = t.id) AS totalVentas,
                (SELECT GROUP_CONCAT(CONCAT_WS(' ', u.nombresUsuario, u.apellidosUsuario, CONCAT('(', u.correo, ')')) ORDER BY u.idUsuario SEPARATOR ', ')
                    FROM usuario u WHERE u.tenant_id = t.id AND u.rol_idRol = 1) AS administradores
             FROM tenants t
             ORDER BY t.nombre"
        );
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public static function find($id)
    {
        if ($id === null || (int)$id < 1) {
            return null;
        }
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT * FROM tenants WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function findBySlug($slug)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT * FROM tenants WHERE slug = ? LIMIT 1');
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function create($data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare(
            'INSERT INTO tenants (nombre, slug, documento, correo, telefono, direccion, logo, estado) VALUES (?,?,?,?,?,?,?,?)'
        );
        $documento = $data['documento'] ?? null;
        $correo = $data['correo'] ?? null;
        $telefono = $data['telefono'] ?? null;
        $direccion = $data['direccion'] ?? null;
        $logo = $data['logo'] ?? null;
        $estado = $data['estado'] ?? 'Activo';
        $stmt->bind_param(
            'ssssssss',
            $data['nombre'],
            $data['slug'],
            $documento,
            $correo,
            $telefono,
            $direccion,
            $logo,
            $estado
        );
        if (!$stmt->execute()) {
            throw new RuntimeException('No se pudo crear el tenant: ' . $stmt->error);
        }
        return $db->insert_id;
    }

    public static function update($id, $data)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare(
            'UPDATE tenants SET nombre=?, slug=?, documento=?, correo=?, telefono=?, direccion=?, logo=?, estado=? WHERE id=?'
        );
        $documento = $data['documento'] ?? null;
        $correo = $data['correo'] ?? null;
        $telefono = $data['telefono'] ?? null;
        $direccion = $data['direccion'] ?? null;
        $logo = $data['logo'] ?? null;
        $estado = $data['estado'] ?? 'Activo';
        $stmt->bind_param(
            'ssssssssi',
            $data['nombre'],
            $data['slug'],
            $documento,
            $correo,
            $telefono,
            $direccion,
            $logo,
            $estado,
            $id
        );
        return $stmt->execute();
    }

    public static function setEstado($id, $estado)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('UPDATE tenants SET estado = ? WHERE id = ?');
        $stmt->bind_param('si', $estado, $id);
        return $stmt->execute();
    }
}