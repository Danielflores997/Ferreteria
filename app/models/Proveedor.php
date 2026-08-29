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

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM proveedor WHERE idProveedor = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO proveedor (idProveedor, nombreProveedor, apellidoProveedor, telefonoProveedor, direccionProveedor, correoProveedor) VALUES (?,?,?,?,?,?)');
        $stmt->bind_param(
            'ssssss',
            $data['id'],
            $data['nombre'],
            $data['apellido'],
            $data['telefono'],
            $data['direccion'],
            $data['correo']
        );
        return $stmt->execute();
    }

    public function exists($id)
    {
        $stmt = $this->db->prepare('SELECT idProveedor FROM proveedor WHERE idProveedor = ?');
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare('UPDATE proveedor SET nombreProveedor=?, apellidoProveedor=?, telefonoProveedor=?, direccionProveedor=?, correoProveedor=? WHERE idProveedor=?');
        $stmt->bind_param(
            'sssssi',
            $data['nombre'],
            $data['apellido'],
            $data['telefono'],
            $data['direccion'],
            $data['correo'],
            $id
        );
        return $stmt->execute();
    }

    public function delete($id)
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $stmt = $this->db->prepare('DELETE FROM proveedor WHERE idProveedor = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return $ok;
    }
}
