<?php
class Compra extends Model
{
    public function allConDetalle($search = '')
    {
        $sql = "SELECT c.id, u.nombresUsuario AS usuario, u.documentoUsuario AS numeroDocumento,
                       p.nombreProductos AS producto, c.cantidad, c.fecha
                FROM compras c
                JOIN usuario u ON c.usuario_id = u.idUsuario
                JOIN productos p ON c.producto_id = p.idProducto
                WHERE u.nombresUsuario LIKE CONCAT('%', ?, '%')
                   OR u.documentoUsuario LIKE CONCAT('%', ?, '%')
                   OR p.nombreProductos LIKE CONCAT('%', ?, '%')
                   OR c.cantidad LIKE CONCAT('%', ?, '%')
                   OR c.fecha LIKE CONCAT('%', ?, '%')
                ORDER BY c.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sssss', $search, $search, $search, $search, $search);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create($usuarioId, $productoId, $cantidad)
    {
        $stmt = $this->db->prepare('INSERT INTO compras (usuario_id, producto_id, cantidad) VALUES (?,?,?)');
        $stmt->bind_param('iii', $usuarioId, $productoId, $cantidad);
        return $stmt->execute();
    }
}
