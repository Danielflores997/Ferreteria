<?php
class Tenant extends Model
{
    public static function all()
    {
        $result = $db = Database::getInstance()->getConnection()->query('SELECT * FROM tenants ORDER BY nombre');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public static function find($id)
    {
        $stmt = $db = Database::getInstance()->getConnection()->prepare('SELECT * FROM tenants WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function findBySlug($slug)
    {
        $stmt = $db = Database::getInstance()->getConnection()->prepare('SELECT * FROM tenants WHERE slug = ? LIMIT 1');
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function create($data)
    {
        $stmt = $db = Database::getInstance()->getConnection()->prepare(
            'INSERT INTO tenants (nombre, slug, documento, correo, telefono, direccion, logo, estado) VALUES (?,?,?,?,?,?,?,?)'
        );
        $stmt->bind_param(
            'sssssssi',
            $data['nombre'],
            $data['slug'],
            $data['documento'] ?? null,
            $data['correo'] ?? null,
            $data['telefono'] ?? null,
            $data['direccion'] ?? null,
            $data['logo'] ?? null,
            $data['estado'] ?? 'Activo'
        );
        $ok = $stmt->execute();
        if ($ok) {
            return $db->insert_id;
        }
        return false;
    }

    public static function update($id, $data)
    {
        $stmt = $db = Database::getInstance()->getConnection()->prepare(
            'UPDATE tenants SET nombre=?, slug=?, documento=?, correo=?, telefono=?, direccion=?, logo=?, estado=? WHERE id=?'
        );
        $stmt->bind_param(
            'sssssssi',
            $data['nombre'],
            $data['slug'],
            $data['documento'] ?? null,
            $data['correo'] ?? null,
            $data['telefono'] ?? null,
            $data['direccion'] ?? null,
            $data['logo'] ?? null,
            $data['estado'] ?? 'Activo',
            $id
        );
        return $stmt->execute();
    }

    public static function setEstado($id, $estado)
    {
        $stmt = $db = Database::getInstance()->getConnection()->prepare('UPDATE tenants SET estado = ? WHERE id = ?');
        $stmt->bind_param('si', $estado, $id);
        return $stmt->execute();
    }
}