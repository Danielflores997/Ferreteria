<?php
class Categoria extends Model
{
    public function all()
    {
        $result = $this->db->query('SELECT * FROM categoria ORDER BY idCategoria');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function map()
    {
        $map = [];
        foreach ($this->all() as $c) {
            $map[$c['idCategoria']] = $c['nombreCategoria'];
        }
        return $map;
    }
}
