<?php
class Cliente extends Model
{
    public function all($search = null)
    {
        if ($search) {
            $like = '%' . $search . '%';
            $stmt = $this->db->prepare("SELECT * FROM cliente WHERE documentoCliente LIKE ? OR nombresCliente LIKE ? OR telefonoCliente LIKE ? OR apellidosCliente LIKE ? OR estadoCliente LIKE ?");
            $stmt->bind_param('sssss', $like, $like, $like, $like, $like);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        $result = $this->db->query('SELECT * FROM cliente ORDER BY idCliente DESC');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function allByTenant($tenantId, $search = null)
    {
        $sql = 'SELECT * FROM cliente WHERE tenant_id = ?';
        if ($search !== null && $search !== '') {
            $sql .= ' AND (documentoCliente LIKE ? OR nombresCliente LIKE ? OR telefonoCliente LIKE ? OR apellidosCliente LIKE ? OR estadoCliente LIKE ?)';
        }
        $sql .= ' ORDER BY idCliente DESC';
        $stmt = $this->db->prepare($sql);
        if ($search !== null && $search !== '') {
            $like = '%' . $search . '%';
            $stmt->bind_param('isssss', $tenantId, $like, $like, $like, $like, $like);
        } else {
            $stmt->bind_param('i', $tenantId);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM cliente WHERE idCliente = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findByIdTenant($tenantId, $id)
    {
        $stmt = $this->db->prepare('SELECT * FROM cliente WHERE idCliente = ? AND tenant_id = ? LIMIT 1');
        $stmt->bind_param('ii', $id, $tenantId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findByDocumento($documento, $tenantId = null)
    {
        $sql = 'SELECT * FROM cliente WHERE documentoCliente = ?';
        if ($tenantId !== null) {
            $sql .= ' AND tenant_id = ?';
        }
        $sql .= ' LIMIT 1';
        $stmt = $this->db->prepare($sql);
        if ($tenantId !== null) {
            $stmt->bind_param('si', $documento, $tenantId);
        } else {
            $stmt->bind_param('s', $documento);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function saveFromSale($tenantId, array $data)
    {
        $cliente = $this->findByDocumento($data['documento'], $tenantId);
        if ($cliente) {
            $stmt = $this->db->prepare(
                'UPDATE cliente SET tipoDocumentoCliente=?, nombresCliente=?, apellidosCliente=?, telefonoCliente=?, direccionCliente=?, estadoCliente=? WHERE idCliente=? AND tenant_id=?'
            );
            $id = (int)$cliente['idCliente'];
            $stmt->bind_param(
                'ssssssii',
                $data['tipoDocumento'],
                $data['nombres'],
                $data['apellidos'],
                $data['telefono'],
                $data['direccion'],
                $data['estado'],
                $id,
                $tenantId
            );
            return $stmt->execute();
        }

        $stmt = $this->db->prepare(
            'INSERT INTO cliente (tipoDocumentoCliente, documentoCliente, nombresCliente, apellidosCliente, telefonoCliente, direccionCliente, estadoCliente, tenant_id) VALUES (?,?,?,?,?,?,?,?)'
        );
        $stmt->bind_param(
            'sssssssi',
            $data['tipoDocumento'],
            $data['documento'],
            $data['nombres'],
            $data['apellidos'],
            $data['telefono'],
            $data['direccion'],
            $data['estado'],
            $tenantId
        );
        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare('UPDATE cliente SET tipoDocumentoCliente=?, documentoCliente=?, nombresCliente=?, apellidosCliente=?, telefonoCliente=?, direccionCliente=?, estadoCliente=? WHERE idCliente=? AND tenant_id=?');
        $tenantId = (int)$data['tenant_id'];
        $stmt->bind_param(
            'sssssssii',
            $data['tipoDocumento'],
            $data['documento'],
            $data['nombres'],
            $data['apellidos'],
            $data['telefono'],
            $data['direccion'],
            $data['estado'],
            $id,
            $tenantId
        );
        return $stmt->execute();
    }

    public function delete($tenantId, $id)
    {
        $stmt = $this->db->prepare('DELETE FROM cliente WHERE idCliente = ? AND tenant_id = ?');
        $stmt->bind_param('ii', $id, $tenantId);
        return $stmt->execute();
    }

    public function documentoExists($documento, $exceptId = null, $tenantId = null)
    {
        if ($tenantId !== null && $exceptId !== null) {
            $stmt = $this->db->prepare('SELECT idCliente FROM cliente WHERE documentoCliente = ? AND idCliente != ? AND tenant_id = ?');
            $stmt->bind_param('sii', $documento, $exceptId, $tenantId);
        } elseif ($tenantId !== null) {
            $stmt = $this->db->prepare('SELECT idCliente FROM cliente WHERE documentoCliente = ? AND tenant_id = ?');
            $stmt->bind_param('si', $documento, $tenantId);
        } elseif ($exceptId !== null) {
            $stmt = $this->db->prepare('SELECT idCliente FROM cliente WHERE documentoCliente = ? AND idCliente != ?');
            $stmt->bind_param('si', $documento, $exceptId);
        } else {
            $stmt = $this->db->prepare('SELECT idCliente FROM cliente WHERE documentoCliente = ?');
            $stmt->bind_param('s', $documento);
        }
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
}
