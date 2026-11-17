<?php
class Peticion extends Model
{
    public function all()
    {
        $result = $this->db->query('SELECT * FROM peticiones');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function allByTenant($tenantId)
    {
        $stmt = $this->db->prepare('SELECT * FROM peticiones WHERE tenant_id = ? ORDER BY idPeticion DESC');
        $stmt->bind_param('i', $tenantId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateEstado($idPeticion, $estado, $tenantId)
    {
        $stmt = $this->db->prepare('UPDATE peticiones SET Estado = ? WHERE idPeticion = ? AND tenant_id = ?');
        $stmt->bind_param('sii', $estado, $idPeticion, $tenantId);
        return $stmt->execute();
    }

    public function createForTenants($data, array $tenantIds)
    {
        if ($tenantIds === []) {
            throw new InvalidArgumentException('Debe seleccionarse al menos una ferretería.');
        }

        $stmt = $this->db->prepare(
            'INSERT INTO peticiones (Nombre, Apellido, Direccion, Telefono, Correo, Motivo, Estado, tenant_id)
             SELECT ?, ?, ?, ?, ?, ?, "No", t.id
             FROM tenants t
             WHERE t.id = ? AND t.estado = "Activo"'
        );
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $direccion = $data['direccion'];
        $telefono = (string)$data['telefono'];
        $correo = $data['correo'];
        $motivo = $data['motivo'];

        $this->db->begin_transaction();
        try {
            foreach ($tenantIds as $tenantId) {
                $stmt->bind_param('ssssssi', $nombre, $apellido, $direccion, $telefono, $correo, $motivo, $tenantId);
                if (!$stmt->execute() || $stmt->affected_rows !== 1) {
                    throw new RuntimeException('No se pudo enviar la petición a una de las ferreterías seleccionadas.');
                }
            }
            $this->db->commit();
        } catch (mysqli_sql_exception | RuntimeException $error) {
            $this->db->rollback();
            throw $error;
        }

        return count($tenantIds);
    }
}
