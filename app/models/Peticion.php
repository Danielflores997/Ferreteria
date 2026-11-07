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

    public function create($data, $tenantId = null)
    {
        $stmt = $this->db->prepare('INSERT INTO peticiones (Nombre, Apellido, Direccion, Telefono, Correo, Motivo, Estado, tenant_id) VALUES (?,?,?,?,?,?,"No",?)');
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $direccion = $data['direccion'];
        $telefono = (string)$data['telefono'];
        $correo = $data['correo'];
        $motivo = $data['motivo'];
        $stmt->bind_param('ssssssi', $nombre, $apellido, $direccion, $telefono, $correo, $motivo, $tenantId);
        return $stmt->execute();
    }
}
