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
        $stmt->bind_param(
            'sssiss',
            $data['nombre'],
            $data['apellido'],
            $data['direccion'],
            $data['telefono'],
            $data['correo'],
            $data['motivo']
        );
        return $stmt->execute();
    }
}
