<?php
class Usuario extends Model
{
    public function autenticar($correo, $clave)
    {
        $stmt = $this->db->prepare('SELECT * FROM usuario WHERE correo = ? LIMIT 1');
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $usuario = $stmt->get_result()->fetch_assoc();
        if (!$usuario) {
            return null;
        }

        $stored = (string)$usuario['claveUsuario'];
        $passwordInfo = password_get_info($stored);
        if ($passwordInfo['algo'] !== null) {
            return password_verify($clave, $stored) ? $usuario : null;
        }
        if (!hash_equals($stored, (string)$clave)) {
            return null;
        }

        $hash = password_hash($clave, PASSWORD_DEFAULT);
        $upgrade = $this->db->prepare('UPDATE usuario SET claveUsuario = ? WHERE idUsuario = ? AND claveUsuario = ?');
        $upgrade->bind_param('sis', $hash, $usuario['idUsuario'], $stored);
        if (!$upgrade->execute()) {
            throw new RuntimeException('No se pudo actualizar de forma segura la contraseña.');
        }
        if ($upgrade->affected_rows !== 1) {
            return null;
        }
        $usuario['claveUsuario'] = $hash;
        return $usuario;
    }

    public function findByCorreo($correo)
    {
        $stmt = $this->db->prepare('SELECT * FROM usuario WHERE correo = ? LIMIT 1');
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function correoExists($correo, $exceptId = null)
    {
        if ($exceptId !== null) {
            $stmt = $this->db->prepare('SELECT idUsuario FROM usuario WHERE correo = ? AND idUsuario != ? LIMIT 1');
            $stmt->bind_param('si', $correo, $exceptId);
        } else {
            $stmt = $this->db->prepare('SELECT idUsuario FROM usuario WHERE correo = ? LIMIT 1');
            $stmt->bind_param('s', $correo);
        }
        $stmt->execute();
        return (bool)$stmt->get_result()->fetch_assoc();
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

    public function allByTenant($tenantId, $search = null)
    {
        $sql = 'SELECT * FROM usuario WHERE tenant_id = ? AND rol_idRol != 4';
        if ($search !== null && $search !== '') {
            $sql .= ' AND (documentoUsuario LIKE ? OR nombresUsuario LIKE ? OR correo LIKE ? OR estadoUsuario LIKE ? OR apellidosUsuario LIKE ?)';
        }
        $sql .= ' ORDER BY idUsuario DESC';
        $stmt = $this->db->prepare($sql);
        if ($search !== null && $search !== '') {
            $like = '%' . $search . '%';
            $stmt->bind_param('isssss', $tenantId, $like, $like, $like, $like, $like);
        } else {
            $stmt->bind_param('i', $tenantId);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM usuario WHERE idUsuario = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findByIdTenant($tenantId, $id)
    {
        $stmt = $this->db->prepare('SELECT * FROM usuario WHERE idUsuario = ? AND tenant_id = ? AND rol_idRol != 4 LIMIT 1');
        $stmt->bind_param('ii', $id, $tenantId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $data)
    {
        $tenantId = $data['tenant_id'] ?? null;
        if ($tenantId === null || (int)$data['rol'] === 4) {
            return false;
        }
        $stmt = $this->db->prepare('UPDATE usuario SET tipoDocumentoUsuario=?, documentoUsuario=?, nombresUsuario=?, apellidosUsuario=?, correo=?, estadoUsuario=?, rol_idRol=? WHERE idUsuario=? AND tenant_id=? AND rol_idRol != 4');
        $stmt->bind_param(
            'ssssssiii',
            $data['tipoDocumento'],
            $data['documento'],
            $data['nombres'],
            $data['apellidos'],
            $data['correo'],
            $data['estado'],
            $data['rol'],
            $id,
            $tenantId
        );
        $ok = $stmt->execute();
        if ($ok && !empty($data['clave'])) {
            $hash = password_hash($data['clave'], PASSWORD_DEFAULT);
            $stmt2 = $this->db->prepare('UPDATE usuario SET claveUsuario=? WHERE idUsuario=? AND tenant_id=? AND rol_idRol != 4');
            $stmt2->bind_param('sii', $hash, $id, $tenantId);
            return $stmt2->execute();
        }
        return $ok;
    }

    public function delete($tenantId, $id)
    {
        $stmt = $this->db->prepare('DELETE FROM usuario WHERE idUsuario = ? AND tenant_id = ? AND rol_idRol != 4');
        $stmt->bind_param('ii', $id, $tenantId);
        return $stmt->execute();
    }

    public function documentoExists($documento, $exceptId = null, $tenantId = null)
    {
        if ($tenantId !== null && $exceptId !== null) {
            $stmt = $this->db->prepare('SELECT idUsuario FROM usuario WHERE documentoUsuario = ? AND idUsuario != ? AND tenant_id = ?');
            $stmt->bind_param('sii', $documento, $exceptId, $tenantId);
        } elseif ($tenantId !== null) {
            $stmt = $this->db->prepare('SELECT idUsuario FROM usuario WHERE documentoUsuario = ? AND tenant_id = ?');
            $stmt->bind_param('si', $documento, $tenantId);
        } elseif ($exceptId !== null) {
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
        $stmt = $this->db->prepare('INSERT INTO usuario (tipoDocumentoUsuario, documentoUsuario, nombresUsuario, apellidosUsuario, correo, claveUsuario, estadoUsuario, rol_idRol, tenant_id) VALUES (?,?,?,?,?,?,"Activo",3,NULL)');
        $hash = password_hash($data['clave'], PASSWORD_DEFAULT);
        $stmt->bind_param(
            'ssssss',
            $data['tipoDocumento'],
            $data['documento'],
            $data['nombres'],
            $data['apellidos'],
            $data['correo'],
            $hash
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
        $hash = password_hash($clave, PASSWORD_DEFAULT);
        $stmt->bind_param('ss', $hash, $correo);
        return $stmt->execute();
    }

    public function registrarAdmin($data)
    {
        $stmt = $this->db->prepare('INSERT INTO usuario (tipoDocumentoUsuario, documentoUsuario, nombresUsuario, apellidosUsuario, correo, claveUsuario, estadoUsuario, rol_idRol, tenant_id) VALUES (?,?,?,?,?,?,?,?,?)');
        $tenantId = (int)$data['tenant_id'];
        $hash = password_hash($data['clave'], PASSWORD_DEFAULT);
        $stmt->bind_param(
            'sssssssii',
            $data['tipoDocumento'],
            $data['documento'],
            $data['nombres'],
            $data['apellidos'],
            $data['correo'],
            $hash,
            $data['estado'],
            $data['rol'],
            $tenantId
        );
        return $stmt->execute();
    }
}
