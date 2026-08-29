<?php
class Peticion extends Model
{
    public function all()
    {
        $result = $this->db->query('SELECT * FROM peticiones');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function updateEstado($correo, $estado)
    {
        $stmt = $this->db->prepare('UPDATE peticiones SET Estado = ? WHERE Correo = ?');
        $stmt->bind_param('ss', $estado, $correo);
        return $stmt->execute();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO peticiones (Nombre, Apellido, Direccion, Telefono, Correo, Motivo, Estado) VALUES (?,?,?,?,?,?,"No")');
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $direccion = $data['direccion'];
        $telefono = (string)$data['telefono'];
        $correo = $data['correo'];
        $motivo = $data['motivo'];
        $stmt->bind_param('ssssss', $nombre, $apellido, $direccion, $telefono, $correo, $motivo);
        return $stmt->execute();
    }
}
