<?php
class Usuario extends Model
{
    public function autenticar($correo, $clave)
    {
        $stmt = $this->db->prepare('SELECT * FROM usuario WHERE correo = ? AND claveUsuario = ? LIMIT 1');
        $stmt->bind_param('ss', $correo, $clave);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function findByCorreo($correo)
    {
        $stmt = $this->db->prepare('SELECT * FROM usuario WHERE correo = ? LIMIT 1');
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getFotoPerfil($correo)
    {
        $stmt = $this->db->prepare('SELECT fotoPerfil FROM usuario WHERE correo = ? LIMIT 1');
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $stmt->bind_result($foto);
        $stmt->fetch();
        $stmt->close();
        return $foto;
    }

    public function all($search = null)
    {
        if ($search) {
            $like = '%' . $search . '%';
            $stmt = $this->db->prepare("SELECT * FROM usuario WHERE documentoUsuario LIKE ? OR nombresUsuario LIKE ? OR correo LIKE ? OR estadoUsuario LIKE ? OR apellidosUsuario LIKE ?");
            $stmt->bind_param('sssss', $like, $like, $like, $like, $like);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        $result = $this->db->query('SELECT * FROM usuario ORDER BY idUsuario DESC');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM usuario WHERE idUsuario = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare('UPDATE usuario SET tipoDocumentoUsuario=?, documentoUsuario=?, nombresUsuario=?, apellidosUsuario=?, correo=?, estadoUsuario=?, rol_idRol=? WHERE idUsuario=?');
        $stmt->bind_param(
            'ssssssii',
            $data['tipoDocumento'],
            $data['documento'],
            $data['nombres'],
            $data['apellidos'],
            $data['correo'],
            $data['estado'],
            $data['rol'],
            $id
        );
        $ok = $stmt->execute();
        if ($ok && !empty($data['clave'])) {
            $stmt2 = $this->db->prepare('UPDATE usuario SET claveUsuario=? WHERE idUsuario=?');
            $stmt2->bind_param('si', $data['clave'], $id);
            $stmt2->execute();
        }
        return $ok;
    }

    public function delete($id)
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $stmt = $this->db->prepare('DELETE FROM usuario WHERE idUsuario = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return $ok;
    }

    public function documentoExists($documento, $exceptId = null)
    {
        if ($exceptId) {
            $stmt = $this->db->prepare('SELECT idUsuario FROM usuario WHERE documentoUsuario = ? AND idUsuario != ?');
            $stmt->bind_param('si', $documento, $exceptId);
        } else {
            $stmt = $this->db->prepare('SELECT idUsuario FROM usuario WHERE documentoUsuario = ?');
            $stmt->bind_param('s', $documento);
        }
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function registrar($data)
    {
        $stmt = $this->db->prepare('INSERT INTO usuario (tipoDocumentoUsuario, documentoUsuario, nombresUsuario, apellidosUsuario, correo, claveUsuario, estadoUsuario, rol_idRol) VALUES (?,?,?,?,?,?,"Activo",3)');
        $stmt->bind_param(
            'ssssss',
            $data['tipoDocumento'],
            $data['documento'],
            $data['nombres'],
            $data['apellidos'],
            $data['correo'],
            $data['clave']
        );
        return $stmt->execute();
    }

    public function updateFoto($correo, $foto)
    {
        $stmt = $this->db->prepare('UPDATE usuario SET fotoPerfil=? WHERE correo=?');
        $stmt->bind_param('ss', $foto, $correo);
        return $stmt->execute();
    }

    public function updatePasswordByCorreo($correo, $clave)
    {
        $stmt = $this->db->prepare('UPDATE usuario SET claveUsuario=? WHERE correo=?');
        $stmt->bind_param('ss', $clave, $correo);
        return $stmt->execute();
    }

    public function registrarAdmin($data)
    {
        $stmt = $this->db->prepare('INSERT INTO usuario (tipoDocumentoUsuario, documentoUsuario, nombresUsuario, apellidosUsuario, correo, claveUsuario, estadoUsuario, rol_idRol) VALUES (?,?,?,?,?,?,?,?)');
        $stmt->bind_param(
            'sssssssi',
            $data['tipoDocumento'],
            $data['documento'],
            $data['nombres'],
            $data['apellidos'],
            $data['correo'],
            $data['clave'],
            $data['estado'],
            $data['rol']
        );
        return $stmt->execute();
    }
}
