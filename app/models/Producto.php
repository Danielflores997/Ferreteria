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

    public function allByTenant($tenantId, $search = null)
    {
        if ($search) {
            $like = '%' . $search . '%';
            $stmt = $this->db->prepare(self::SELECT_BASE . ' WHERE p.tenant_id = ? AND (p.codigoProducto LIKE ? OR p.nombreProductos LIKE ? OR p.stockProducto LIKE ? OR c.nombreCategoria LIKE ? OR p.descripcionProducto LIKE ?) ORDER BY p.idProducto DESC');
            $stmt->bind_param('isssss', $tenantId, $like, $like, $like, $like, $like);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        $stmt = $this->db->prepare(self::SELECT_BASE . ' WHERE p.tenant_id = ? ORDER BY p.idProducto DESC');
        $stmt->bind_param('i', $tenantId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare(self::SELECT_BASE . ' WHERE p.idProducto = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findByIdTenant($tenantId, $id)
    {
        $stmt = $this->db->prepare(self::SELECT_BASE . ' WHERE p.idProducto = ? AND p.tenant_id = ? LIMIT 1');
        $stmt->bind_param('ii', $id, $tenantId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findByCodigo($codigo, $tenantId = null)
    {
        $where = $tenantId !== null ? ' AND p.tenant_id = ?' : '';
        $stmt = $this->db->prepare(self::SELECT_BASE . ' WHERE p.codigoProducto = ?' . $where . ' LIMIT 1');
        if ($tenantId !== null) {
            $stmt->bind_param('si', $codigo, $tenantId);
        } else {
            $stmt->bind_param('s', $codigo);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findByCodigoTenant($codigo, $tenantId)
    {
        $stmt = $this->db->prepare(self::SELECT_BASE . ' WHERE p.codigoProducto = ? AND p.tenant_id = ? LIMIT 1');
        $stmt->bind_param('si', $codigo, $tenantId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function ultimoCodigo($tenantId = null)
    {
        $where = $tenantId !== null ? ' WHERE p.tenant_id = ?' : '';
        $sql = 'SELECT MAX(p.codigoProducto) AS ultimoCodigo FROM productos p' . $where;
        $stmt = $this->db->prepare($sql);
        if ($tenantId !== null) {
            $stmt->bind_param('i', $tenantId);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result ? $result->fetch_assoc() : null;
        return $row ? $row['ultimoCodigo'] : '';
    }

    public function create($data, $tenantId = null)
    {
        $categoria = $this->categoriaId($data['categoria']);
        $stmt = $this->db->prepare('INSERT INTO productos (codigoProducto, nombreProductos, valorProducto, stockProducto, descripcionProducto, nombreCategoria, imagen, tenant_id) VALUES (?,?,?,?,?,?,?,?)');
        $tenantId = $tenantId ?? tenantId();
        $stmt->bind_param(
            'ssdisisi',
            $data['codigo'],
            $data['nombre'],
            $data['precio'],
            $data['stock'],
            $data['descripcion'],
            $categoria,
            $data['imagen'],
            $tenantId
        );
        return $stmt->execute();
    }

    public function sumarStock($codigo, $cantidad, $tenantId = null)
    {
        $tenantId = $tenantId ?? tenantId();
        if ($cantidad <= 0 || $tenantId === null) {
            return false;
        }
        $stmt = $this->db->prepare('UPDATE productos SET stockProducto = stockProducto + ? WHERE codigoProducto = ? AND tenant_id = ?');
        $stmt->bind_param('isi', $cantidad, $codigo, $tenantId);
        return $stmt->execute();
    }

    public function restarStock($codigo, $cantidad, $tenantId = null)
    {
        $tenantId = $tenantId ?? tenantId();
        if ($cantidad <= 0 || $tenantId === null) {
            return false;
        }
        $stmt = $this->db->prepare('UPDATE productos SET stockProducto = stockProducto - ? WHERE codigoProducto = ? AND tenant_id = ? AND stockProducto >= ?');
        $stmt->bind_param('isii', $cantidad, $codigo, $tenantId, $cantidad);
        return $stmt->execute() && $stmt->affected_rows === 1;
    }

    public function byCategoriaNombre($nombre)
    {
        $id = $this->categoriaId($nombre);
        $sql = 'SELECT p.*, c.nombreCategoria AS categoriaNombre, t.nombre AS tenantNombre, t.slug AS tenantSlug FROM productos p JOIN tenants t ON t.id = p.tenant_id LEFT JOIN categoria c ON c.idCategoria = p.nombreCategoria WHERE t.estado = ? AND (p.nombreCategoria = ? OR c.nombreCategoria = ?) ORDER BY p.idProducto DESC';
        $stmt = $this->db->prepare($sql);
        $estado = 'Activo';
        $stmt->bind_param('sis', $estado, $id, $nombre);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        if ($rows) {
            return $rows;
        }

        $like = '%' . $nombre . '%';
        $stmt = $this->db->prepare('SELECT p.*, c.nombreCategoria AS categoriaNombre, t.nombre AS tenantNombre, t.slug AS tenantSlug FROM productos p JOIN tenants t ON t.id = p.tenant_id LEFT JOIN categoria c ON c.idCategoria = p.nombreCategoria WHERE t.estado = ? AND c.nombreCategoria LIKE ? ORDER BY p.idProducto DESC');
        $stmt->bind_param('ss', $estado, $like);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function byCategoriaNombrePaginado($nombre, $limite = 12, $offset = 0)
    {
        $id = $this->categoriaId($nombre);
        $where = "t.estado = 'Activo' AND (p.nombreCategoria = ? OR c.nombreCategoria = ?)";
        $count = $this->db->prepare(
            "SELECT COUNT(*) AS total FROM productos p JOIN tenants t ON t.id = p.tenant_id LEFT JOIN categoria c ON c.idCategoria = p.nombreCategoria WHERE {$where}"
        );
        $count->bind_param('is', $id, $nombre);
        $count->execute();
        $total = (int)($count->get_result()->fetch_assoc()['total'] ?? 0);

        $stmt = $this->db->prepare(
            "SELECT p.*, c.nombreCategoria AS categoriaNombre, t.nombre AS tenantNombre, t.slug AS tenantSlug FROM productos p JOIN tenants t ON t.id = p.tenant_id LEFT JOIN categoria c ON c.idCategoria = p.nombreCategoria WHERE {$where} ORDER BY p.idProducto DESC LIMIT ? OFFSET ?"
        );
        $limite = max(1, min(100, (int)$limite));
        $offset = max(0, (int)$offset);
        $stmt->bind_param('isii', $id, $nombre, $limite, $offset);
        $stmt->execute();
        return [
            'rows' => $stmt->get_result()->fetch_all(MYSQLI_ASSOC),
            'total' => $total,
        ];
    }

    public function update($id, $data)
    {
        $categoria = $this->categoriaId($data['categoria']);
        if ($categoria === 0) {
            $actual = isset($data['tenant_id'])
                ? $this->findByIdTenant((int)$data['tenant_id'], $id)
                : $this->find($id);
            $categoria = $actual ? (int)$actual['nombreCategoria'] : 0;
        }
        $tenantId = $data['tenant_id'] ?? null;
        $sql = 'UPDATE productos SET codigoProducto=?, nombreProductos=?, valorProducto=?, stockProducto=?, descripcionProducto=?, nombreCategoria=?, imagen=? WHERE idProducto=?';
        if ($tenantId !== null) {
            $sql .= ' AND tenant_id=?';
        }
        $stmt = $this->db->prepare($sql);
        if ($tenantId !== null) {
            $stmt->bind_param(
                'ssdisisii',
                $data['codigo'],
                $data['nombre'],
                $data['precio'],
                $data['stock'],
                $data['descripcion'],
                $categoria,
                $data['imagen'],
                $id,
                $tenantId
            );
        } else {
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
        }
        return $stmt->execute();
    }

    public function delete($tenantId, $id)
    {
        $stmt = $this->db->prepare('DELETE FROM productos WHERE idProducto = ? AND tenant_id = ?');
        $stmt->bind_param('ii', $id, $tenantId);
        return $stmt->execute();
    }

    public function bajoStock($tenantId, $limite = 10)
    {
        $stmt = $this->db->prepare(self::SELECT_BASE . ' WHERE p.tenant_id = ? AND p.stockProducto < ?');
        $stmt->bind_param('ii', $tenantId, $limite);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function marketplace($search = null, $orden = 'p.idProducto DESC', $limite = 12, $offset = 0)
    {
        $allowedOrders = [
            'p.idProducto DESC',
            'p.idProducto ASC',
            'p.nombreProductos ASC',
            'p.nombreProductos DESC',
            'p.valorProducto ASC',
            'p.valorProducto DESC',
        ];
        if (!in_array($orden, $allowedOrders, true)) {
            $orden = 'p.idProducto DESC';
        }
        $sql = "SELECT SQL_CALC_FOUND_ROWS p.*, c.nombreCategoria AS categoriaNombre, t.nombre AS tenantNombre, t.slug AS tenantSlug FROM productos p JOIN tenants t ON t.id = p.tenant_id LEFT JOIN categoria c ON c.idCategoria = p.nombreCategoria WHERE t.estado = 'Activo'";
        if ($search !== null && $search !== '') {
            $sql .= ' AND (p.codigoProducto LIKE ? OR p.nombreProductos LIKE ? OR p.descripcionProducto LIKE ? OR c.nombreCategoria LIKE ?)';
        }
        $sql .= " ORDER BY {$orden} LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($sql);
        $limite = max(1, min(100, (int)$limite));
        $offset = max(0, (int)$offset);
        if ($search !== null && $search !== '') {
            $like = '%' . $search . '%';
            $stmt->bind_param('ssssii', $like, $like, $like, $like, $limite, $offset);
        } else {
            $stmt->bind_param('ii', $limite, $offset);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $countR = $this->db->query('SELECT FOUND_ROWS() AS total');
        $total = $countR ? (int)($countR->fetch_assoc()['total']) : count($rows);
        return ['rows' => $rows, 'total' => $total];
    }

    public function assistantCandidates($query, $limit = 12)
    {
        $tokens = preg_split('/[^\p{L}\p{N}]+/u', (string)$query, -1, PREG_SPLIT_NO_EMPTY);
        $stopWords = [
            'busco', 'necesito', 'quiero', 'para', 'con', 'una', 'uno', 'unos', 'unas',
            'que', 'como', 'del', 'por', 'las', 'los', 'algo', 'ayuda', 'tengo', 'me',
            'sirve', 'usar', 'uso', 'este', 'esta', 'estos', 'estas', 'hacer',
        ];
        $terms = [];
        foreach ($tokens ?: [] as $token) {
            $token = strtolower($token);
            if (strlen($token) < 2 || in_array($token, $stopWords, true) || in_array($token, $terms, true)) {
                continue;
            }
            $terms[] = $token;
            if (count($terms) === 8) {
                break;
            }
        }
        if ($terms === []) {
            return [];
        }

        $conditions = [];
        $scoreParts = [];
        $conditionValues = [];
        $scoreValues = [];
        foreach ($terms as $term) {
            $conditions[] = '(p.codigoProducto LIKE ? OR p.nombreProductos LIKE ? OR p.descripcionProducto LIKE ? OR c.nombreCategoria LIKE ?)';
            $like = '%' . $term . '%';
            array_push($conditionValues, $like, $like, $like, $like);
            $scoreParts[] = '(CASE WHEN p.codigoProducto LIKE ? THEN 5 ELSE 0 END'
                . ' + CASE WHEN p.nombreProductos LIKE ? THEN 4 ELSE 0 END'
                . ' + CASE WHEN c.nombreCategoria LIKE ? THEN 3 ELSE 0 END'
                . ' + CASE WHEN p.descripcionProducto LIKE ? THEN 2 ELSE 0 END)';
            array_push($scoreValues, $like, $like, $like, $like);
        }

        $sql = 'SELECT (' . implode(' + ', $scoreParts) . ') AS relevancia, '
            . 'p.idProducto, p.nombreProductos, p.valorProducto, p.stockProducto, p.descripcionProducto, p.imagen, '
            . 'c.nombreCategoria AS categoriaNombre, t.nombre AS tenantNombre '
            . 'FROM productos p '
            . 'JOIN tenants t ON t.id = p.tenant_id '
            . 'LEFT JOIN categoria c ON c.idCategoria = p.nombreCategoria '
            . 'WHERE t.estado = ? AND p.stockProducto > 0 AND (' . implode(' OR ', $conditions) . ') '
            . 'ORDER BY relevancia DESC, p.idProducto DESC LIMIT ?';
        $values = array_merge($scoreValues, ['Activo'], $conditionValues, [max(1, min(12, (int)$limit))]);

        $stmt = $this->db->prepare($sql);
        $types = str_repeat('s', count($values) - 1) . 'i';
        $bindValues = [$types];
        foreach ($values as $index => &$value) {
            $bindValues[] = &$value;
        }
        unset($value);
        call_user_func_array([$stmt, 'bind_param'], $bindValues);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countMarketplace($search = null)
    {
        $sql = "SELECT COUNT(*) AS total FROM productos p JOIN tenants t ON t.id = p.tenant_id LEFT JOIN categoria c ON c.idCategoria = p.nombreCategoria WHERE t.estado = 'Activo'";
        if ($search !== null && $search !== '') {
            $sql .= ' AND (p.codigoProducto LIKE ? OR p.nombreProductos LIKE ? OR p.descripcionProducto LIKE ? OR c.nombreCategoria LIKE ?)';
            $stmt = $this->db->prepare($sql);
            $like = '%' . $search . '%';
            $stmt->bind_param('ssss', $like, $like, $like, $like);
        } else {
            $stmt = $this->db->prepare($sql);
        }
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return (int)($row['total'] ?? 0);
    }

    public function findPublic($id)
    {
        $stmt = $this->db->prepare('SELECT p.*, c.nombreCategoria AS categoriaNombre, t.nombre AS tenantNombre, t.slug AS tenantSlug FROM productos p JOIN tenants t ON t.id = p.tenant_id LEFT JOIN categoria c ON c.idCategoria = p.nombreCategoria WHERE p.idProducto = ? AND t.estado = ? LIMIT 1');
        $estado = 'Activo';
        $stmt->bind_param('is', $id, $estado);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function similares($idProducto, $limite = 8)
    {
        $actual = $this->find($idProducto);
        if (!$actual) return [];
        $catId = $actual['nombreCategoria'];
        $sql = "SELECT p.*, c.nombreCategoria AS categoriaNombre, t.nombre AS tenantNombre, t.slug AS tenantSlug FROM productos p LEFT JOIN categoria c ON c.idCategoria = p.nombreCategoria LEFT JOIN tenants t ON t.id = p.tenant_id WHERE p.nombreCategoria = ? AND p.idProducto != ? AND t.estado = 'Activo' ORDER BY RAND() LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('isi', $catId, $idProducto, $limite);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
