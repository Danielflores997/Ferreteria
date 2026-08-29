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

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM cliente WHERE idCliente = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findByDocumento($documento)
    {
        $stmt = $this->db->prepare('SELECT * FROM cliente WHERE documentoCliente = ? LIMIT 1');
        $stmt->bind_param('s', $documento);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare('UPDATE cliente SET tipoDocumentoCliente=?, documentoCliente=?, nombresCliente=?, apellidosCliente=?, telefonoCliente=?, direccionCliente=?, estadoCliente=? WHERE idCliente=?');
        $stmt->bind_param(
            'sssssssi',
            $data['tipoDocumento'],
            $data['documento'],
            $data['nombres'],
            $data['apellidos'],
            $data['telefono'],
            $data['direccion'],
            $data['estado'],
            $id
        );
        return $stmt->execute();
    }

    public function delete($id)
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $stmt = $this->db->prepare('DELETE FROM cliente WHERE idCliente = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return $ok;
    }

    public function documentoExists($documento, $exceptId = null)
    {
        if ($exceptId) {
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
