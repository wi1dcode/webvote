<?php

namespace App\Model;

use Core\Model;

class PetitionModel extends Model
{
    public function listPublished($filters = [])
    {
        $where = ['p.status = :status'];
        $params = ['status' => 'PUBLISHED'];

        if (!empty($filters['q'])) {
            $where[] = 'p.title LIKE :q';
            $params['q'] = '%' . $filters['q'] . '%';
        }

        if (!empty($filters['category_id'])) {
            $where[] = 'p.category_id = :category_id';
            $params['category_id'] = (int)$filters['category_id'];
        }

        $sql = 'SELECT p.*, u.pseudo, c.name AS category_name,
                (SELECT COUNT(*) FROM signatures s WHERE s.petition_id = p.id) AS signatures_count
                FROM petitions p
                JOIN users u ON u.id = p.user_id
                JOIN categories c ON c.id = p.category_id
                WHERE ' . implode(' AND ', $where) . '
                ORDER BY p.created_at DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function listByUser($userId)
    {
        $stmt = $this->db->prepare('SELECT p.*,
            (SELECT COUNT(*) FROM signatures s WHERE s.petition_id = p.id) AS signatures_count,
            c.name AS category_name
            FROM petitions p
            JOIN categories c ON c.id = p.category_id
            WHERE p.user_id = :user_id
            ORDER BY p.created_at DESC');
        $stmt->execute(['user_id' => (int)$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT p.*, u.pseudo, u.avatar, c.name AS category_name,
            (SELECT COUNT(*) FROM signatures s WHERE s.petition_id = p.id) AS signatures_count
            FROM petitions p
            JOIN users u ON u.id = p.user_id
            JOIN categories c ON c.id = p.category_id
            WHERE p.id = :id
            LIMIT 1');
        $stmt->execute(['id' => (int)$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    public function create($userId, $categoryId, $title, $description, $goal, $imagePath)
    {
        $stmt = $this->db->prepare('INSERT INTO petitions (user_id, category_id, title, description, image, goal_signatures, status, created_at)
            VALUES (:user_id, :category_id, :title, :description, :image, :goal, :status, NOW())');
        $stmt->execute([
            'user_id' => (int)$userId,
            'category_id' => (int)$categoryId,
            'title' => $title,
            'description' => $description,
            'image' => $imagePath,
            'goal' => (int)$goal,
            'status' => 'PUBLISHED'
        ]);
        return (int)$this->getLastInsertId();
    }

    public function update($id, $categoryId, $title, $description, $goal, $imagePath = null)
    {
        $fields = 'category_id = :category_id, title = :title, description = :description, goal_signatures = :goal';
        $params = [
            'id' => (int)$id,
            'category_id' => (int)$categoryId,
            'title' => $title,
            'description' => $description,
            'goal' => (int)$goal
        ];

        if ($imagePath !== null) {
            $fields .= ', image = :image';
            $params['image'] = $imagePath;
        }

        $stmt = $this->db->prepare('UPDATE petitions SET ' . $fields . ' WHERE id = :id');
        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM petitions WHERE id = :id');
        return $stmt->execute(['id' => (int)$id]);
    }

    public function setStatus($id, $status)
    {
        $stmt = $this->db->prepare('UPDATE petitions SET status = :status WHERE id = :id');
        return $stmt->execute(['status' => $status, 'id' => (int)$id]);
    }

    public function listAdmin()
    {
        $stmt = $this->db->query('SELECT p.*, u.pseudo, c.name AS category_name,
            (SELECT COUNT(*) FROM signatures s WHERE s.petition_id = p.id) AS signatures_count
            FROM petitions p
            JOIN users u ON u.id = p.user_id
            JOIN categories c ON c.id = p.category_id
            ORDER BY p.created_at DESC');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
