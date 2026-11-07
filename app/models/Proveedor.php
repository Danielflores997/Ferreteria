<?php
class Proveedor extends Model
{
    public function all($search = null)
    {
        if ($search) {
            $like = '%' . $search . '%';
            $stmt = $this->db->prepare("SELECT * FROM proveedor WHERE idProveedor LIKE ? OR nombreProveedor LIKE ? OR telefonoProveedor LIKE ? OR direccionProveedor LIKE ? OR correoProveedor LIKE ? OR apellidoProveedor LIKE ?");
            $stmt->bind_param('ssssss', $like, $like, $like, $like, $like, $like);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        $result = $this->db->query('SELECT * FROM proveedor ORDER BY idProveedor DESC');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function allByTenant($tenantId, $search = null)
    {
        $sql = 'SELECT * FROM proveedor WHERE tenant_id = ?';
        if ($search !== null && $search !== '') {
            $sql .= ' AND (idProveedor LIKE ? OR nombreProveedor LIKE ? OR telefonoProveedor LIKE ? OR direccionProveedor LIKE ? OR correoProveedor LIKE ? OR apellidoProveedor LIKE ?)';
        }
        $sql .= ' ORDER BY idProveedor DESC';
        $stmt = $this->db->prepare($sql);
        if ($search !== null && $search !== '') {
            $like = '%' . $search . '%';
            $stmt->bind_param('issssss', $tenantId, $like, $like, $like, $like, $like, $like);
        } else {
            $stmt->bind_param('i', $tenantId);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM proveedor WHERE idProveedor = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findByIdTenant($tenantId, $id)
    {
        $stmt = $this->db->prepare('SELECT * FROM proveedor WHERE idProveedor = ? AND tenant_id = ? LIMIT 1');
        $stmt->bind_param('ii', $id, $tenantId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO proveedor (idProveedor, nombreProveedor, apellidoProveedor, telefonoProveedor, direccionProveedor, correoProveedor, tenant_id) VALUES (?,?,?,?,?,?,?)');
        $id = (int)$data['id'];
        $tenantId = (int)$data['tenant_id'];
        $stmt->bind_param(
            'isssssi',
            $id,
            $data['nombre'],
            $data['apellido'],
            $data['telefono'],
            $data['direccion'],
            $data['correo'],
            $tenantId
        );
        return $stmt->execute();
    }

    public function exists($id, $tenantId)
    {
        $stmt = $this->db->prepare('SELECT idProveedor FROM proveedor WHERE idProveedor = ? AND tenant_id = ?');
        $id = (int)$id;
        $stmt->bind_param('ii', $id, $tenantId);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare('UPDATE proveedor SET nombreProveedor=?, apellidoProveedor=?, telefonoProveedor=?, direccionProveedor=?, correoProveedor=? WHERE idProveedor=? AND tenant_id=?');
        $tenantId = (int)$data['tenant_id'];
        $stmt->bind_param(
            'sssssii',
            $data['nombre'],
            $data['apellido'],
            $data['telefono'],
            $data['direccion'],
            $data['correo'],
            $id,
            $tenantId
        );
        return $stmt->execute();
    }

    public function delete($tenantId, $id)
    {
        $stmt = $this->db->prepare('DELETE FROM proveedor WHERE idProveedor = ? AND tenant_id = ?');
        $stmt->bind_param('ii', $id, $tenantId);
        return $stmt->execute();
    }
}
