<?php
class Producto extends Model
{
    /** productos.nombreCategoria es la FK entera hacia categoria.idCategoria */
    private const SELECT_BASE = 'SELECT p.*, c.nombreCategoria AS categoriaNombre FROM productos p LEFT JOIN categoria c ON c.idCategoria = p.nombreCategoria';

    public function categoriaId($valor)
    {
        if (is_numeric($valor)) {
            return (int)$valor;
        }
        $stmt = $this->db->prepare('SELECT idCategoria FROM categoria WHERE nombreCategoria = ? LIMIT 1');
        $stmt->bind_param('s', $valor);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ? (int)$row['idCategoria'] : 0;
    }

    public function all($search = null)
    {
        if ($search) {
            $like = '%' . $search . '%';
            $stmt = $this->db->prepare(self::SELECT_BASE . ' WHERE p.codigoProducto LIKE ? OR p.nombreProductos LIKE ? OR p.stockProducto LIKE ? OR c.nombreCategoria LIKE ? OR p.descripcionProducto LIKE ? ORDER BY p.idProducto DESC');
            $stmt->bind_param('sssss', $like, $like, $like, $like, $like);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        $result = $this->db->query(self::SELECT_BASE . ' ORDER BY p.idProducto DESC');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function find($id)
    {
        $stmt = $this->db->prepare(self::SELECT_BASE . ' WHERE p.idProducto = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findByCodigo($codigo)
    {
        $stmt = $this->db->prepare(self::SELECT_BASE . ' WHERE p.codigoProducto = ? LIMIT 1');
        $stmt->bind_param('s', $codigo);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function byCategoriaNombre($nombre)
    {
        $id = $this->categoriaId($nombre);
        $stmt = $this->db->prepare(self::SELECT_BASE . ' WHERE p.nombreCategoria = ? OR c.nombreCategoria = ? ORDER BY p.idProducto DESC');
        $stmt->bind_param('is', $id, $nombre);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        if ($rows) {
            return $rows;
        }

        $like = '%' . $nombre . '%';
        $stmt = $this->db->prepare(self::SELECT_BASE . ' WHERE c.nombreCategoria LIKE ? ORDER BY p.idProducto DESC');
        $stmt->bind_param('s', $like);
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
        $categoria = $this->categoriaId($data['categoria']);
        $stmt = $this->db->prepare('INSERT INTO productos (codigoProducto, nombreProductos, valorProducto, stockProducto, descripcionProducto, nombreCategoria, imagen) VALUES (?,?,?,?,?,?,?)');
        $stmt->bind_param(
            'ssdisis',
            $data['codigo'],
            $data['nombre'],
            $data['precio'],
            $data['stock'],
            $data['descripcion'],
            $categoria,
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
        $categoria = $this->categoriaId($data['categoria']);
        if ($categoria === 0) {
            $actual = $this->find($id);
            $categoria = $actual ? (int)$actual['nombreCategoria'] : 0;
        }
        $stmt = $this->db->prepare('UPDATE productos SET codigoProducto=?, nombreProductos=?, valorProducto=?, stockProducto=?, descripcionProducto=?, nombreCategoria=?, imagen=? WHERE idProducto=?');
        $stmt->bind_param(
            'ssdisisi',
            $data['codigo'],
            $data['nombre'],
            $data['precio'],
            $data['stock'],
            $data['descripcion'],
            $categoria,
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
        $stmt = $this->db->prepare(self::SELECT_BASE . ' WHERE p.stockProducto < ?');
        $stmt->bind_param('i', $limite);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
