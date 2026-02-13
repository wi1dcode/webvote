<?php

namespace App\Model;

use Core\Model;

class CategoryModel extends Model
{
    public function listAll()
    {
        $stmt = $this->db->query('SELECT id, name FROM categories ORDER BY name ASC');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT id, name FROM categories WHERE id = :id');
        $stmt->execute(['id' => (int)$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }
}
