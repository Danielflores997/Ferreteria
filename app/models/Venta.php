<?php
class Venta extends Model
{
    public function all($search = null)
    {
        if ($search) {
            $like = '%' . $search . '%';
            $stmt = $this->db->prepare("SELECT * FROM ventas WHERE idcodigo LIKE ? OR producto LIKE ? OR descripcion LIKE ? OR idVenta LIKE ?");
            $stmt->bind_param('ssss', $like, $like, $like, $like);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        $result = $this->db->query('SELECT * FROM ventas ORDER BY idVenta DESC');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function allByTenant($tenantId, $search = null)
    {
        $sql = 'SELECT * FROM ventas WHERE tenant_id = ?';
        if ($search !== null && $search !== '') {
            $sql .= ' AND (idcodigo LIKE ? OR producto LIKE ? OR descripcion LIKE ? OR idVenta LIKE ?)';
        }
        $sql .= ' ORDER BY idVenta DESC';
        $stmt = $this->db->prepare($sql);
        if ($search !== null && $search !== '') {
            $like = '%' . $search . '%';
            $stmt->bind_param('issss', $tenantId, $like, $like, $like, $like);
        } else {
            $stmt->bind_param('i', $tenantId);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM ventas WHERE idVenta = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findByIdTenant($tenantId, $id)
    {
        $stmt = $this->db->prepare('SELECT * FROM ventas WHERE idVenta = ? AND tenant_id = ? LIMIT 1');
        $stmt->bind_param('ii', $id, $tenantId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO ventas (idcodigo, producto, precio_unitario, cantidad, descripcion, Categoria, tenant_id) VALUES (?,?,?,?,?,?,?)');
        $tenantId = (int)$data['tenant_id'];
        $stmt->bind_param(
            'ssdissi',
            $data['codigo'],
            $data['producto'],
            $data['precio'],
            $data['cantidad'],
            $data['descripcion'],
            $data['categoria'],
            $tenantId
        );
        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare('UPDATE ventas SET idcodigo=?, producto=?, precio_unitario=?, cantidad=?, descripcion=?, Categoria=? WHERE idVenta=? AND tenant_id=?');
        $tenantId = (int)$data['tenant_id'];
        $stmt->bind_param(
            'ssdissii',
            $data['codigo'],
            $data['producto'],
            $data['precio'],
            $data['cantidad'],
            $data['descripcion'],
            $data['categoria'],
            $id,
            $tenantId
        );
        return $stmt->execute();
    }

    public function delete($tenantId, $id)
    {
        $stmt = $this->db->prepare('DELETE FROM ventas WHERE idVenta = ? AND tenant_id = ?');
        $stmt->bind_param('ii', $id, $tenantId);
        return $stmt->execute();
    }
}
