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

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM ventas WHERE idVenta = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO ventas (idcodigo, producto, precio_unitario, cantidad, descripcion, Categoria) VALUES (?,?,?,?,?,?)');
        $stmt->bind_param(
            'ssddss',
            $data['codigo'],
            $data['producto'],
            $data['precio'],
            $data['cantidad'],
            $data['descripcion'],
            $data['categoria']
        );
        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare('UPDATE ventas SET idcodigo=?, producto=?, precio_unitario=?, cantidad=?, descripcion=?, Categoria=? WHERE idVenta=?');
        $stmt->bind_param(
            'ssddssi',
            $data['codigo'],
            $data['producto'],
            $data['precio'],
            $data['cantidad'],
            $data['descripcion'],
            $data['categoria'],
            $id
        );
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM ventas WHERE idVenta = ?');
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
