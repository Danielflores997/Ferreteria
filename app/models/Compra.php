<?php
class Compra extends Model
{
    public function allConDetalle($tenantId, $search = '')
    {
        $sql = "SELECT c.id, u.nombresUsuario AS usuario, u.documentoUsuario AS numeroDocumento,
                       p.nombreProductos AS producto, c.cantidad, c.fecha, c.checkout_id
                FROM compras c
                LEFT JOIN usuario u ON c.usuario_id = u.idUsuario
                JOIN productos p ON c.producto_id = p.idProducto AND p.tenant_id = c.tenant_id
                WHERE c.tenant_id = ?
                  AND (u.nombresUsuario LIKE CONCAT('%', ?, '%')
                   OR u.documentoUsuario LIKE CONCAT('%', ?, '%')
                   OR p.nombreProductos LIKE CONCAT('%', ?, '%')
                   OR c.cantidad LIKE CONCAT('%', ?, '%')
                   OR c.fecha LIKE CONCAT('%', ?, '%'))
                ORDER BY c.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('isssss', $tenantId, $search, $search, $search, $search, $search);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create($usuarioId, $productoId, $cantidad, $tenantId = null, $checkoutId = null)
    {
        $stmt = $this->db->prepare('INSERT INTO compras (usuario_id, producto_id, cantidad, tenant_id, checkout_id) VALUES (?,?,?,?,?)');
        $stmt->bind_param('iiiis', $usuarioId, $productoId, $cantidad, $tenantId, $checkoutId);
        return $stmt->execute();
    }
}
