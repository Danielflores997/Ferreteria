<?php
class Compra extends Model
{
    public function allByUser($userId)
    {
        $stmt = $this->db->prepare(
            'SELECT c.id, p.nombreProductos AS producto, c.precio_unitario AS precioUnitario,
                    t.nombre AS ferreteria, c.cantidad, c.fecha
             FROM compras c
             JOIN productos p ON p.idProducto = c.producto_id AND p.tenant_id = c.tenant_id
             JOIN tenants t ON t.id = c.tenant_id
             WHERE c.usuario_id = ?
             ORDER BY c.id DESC'
        );
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

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

    public function create($usuarioId, $productoId, $cantidad, $precioUnitario, $tenantId, $checkoutId)
    {
        $stmt = $this->db->prepare('INSERT INTO compras (usuario_id, producto_id, cantidad, precio_unitario, tenant_id, checkout_id) VALUES (?,?,?,?,?,?)');
        $stmt->bind_param('iiidis', $usuarioId, $productoId, $cantidad, $precioUnitario, $tenantId, $checkoutId);
        return $stmt->execute();
    }
}
