<?php
class Producto extends Model
{
    public function all($search = null)
    {
        if ($search) {
            $like = '%' . $search . '%';
            $stmt = $this->db->prepare("SELECT * FROM productos WHERE codigoProducto LIKE ? OR nombreProductos LIKE ? OR stockProducto LIKE ? OR nombreCategoria LIKE ? OR descripcionProducto LIKE ?");
            $stmt->bind_param('sssss', $like, $like, $like, $like, $like);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        $result = $this->db->query('SELECT * FROM productos ORDER BY idProducto DESC');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM productos WHERE idProducto = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findByCodigo($codigo)
    {
        $stmt = $this->db->prepare('SELECT * FROM productos WHERE codigoProducto = ? LIMIT 1');
        $stmt->bind_param('s', $codigo);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function byCategoriaNombre($nombre)
    {
        $stmt = $this->db->prepare('SELECT * FROM productos WHERE nombreCategoria = ? OR nombreCategoria LIKE ?');
        $like = '%' . $nombre . '%';
        $stmt->bind_param('ss', $nombre, $like);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function ultimoCodigo()
    {
        $result = $this->db->query('SELECT MAX(codigoProducto) AS ultimoCodigo FROM productos');
        $row = $result ? $result->fetch_assoc() : null;
        return $row ? $row['ultimoCodigo'] : '';
    }

    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO productos (codigoProducto, nombreProductos, valorProducto, stockProducto, descripcionProducto, nombreCategoria, imagen) VALUES (?,?,?,?,?,?,?)');
        $stmt->bind_param(
            'ssddsss',
            $data['codigo'],
            $data['nombre'],
            $data['precio'],
            $data['stock'],
            $data['descripcion'],
            $data['categoria'],
            $data['imagen']
        );
        return $stmt->execute();
    }

    public function sumarStock($codigo, $cantidad)
    {
        $stmt = $this->db->prepare('UPDATE productos SET stockProducto = stockProducto + ? WHERE codigoProducto = ?');
        $stmt->bind_param('is', $cantidad, $codigo);
        return $stmt->execute();
    }

    public function restarStock($codigo, $cantidad)
    {
        $stmt = $this->db->prepare('UPDATE productos SET stockProducto = stockProducto - ? WHERE codigoProducto = ?');
        $stmt->bind_param('is', $cantidad, $codigo);
        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare('UPDATE productos SET codigoProducto=?, nombreProductos=?, valorProducto=?, stockProducto=?, descripcionProducto=?, nombreCategoria=?, imagen=? WHERE idProducto=?');
        $stmt->bind_param(
            'ssdisssi',
            $data['codigo'],
            $data['nombre'],
            $data['precio'],
            $data['stock'],
            $data['descripcion'],
            $data['categoria'],
            $data['imagen'],
            $id
        );
        return $stmt->execute();
    }

    public function delete($id)
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $stmt = $this->db->prepare('DELETE FROM productos WHERE idProducto = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return $ok;
    }

    public function bajoStock($limite = 10)
    {
        $stmt = $this->db->prepare('SELECT * FROM productos WHERE stockProducto < ?');
        $stmt->bind_param('i', $limite);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
