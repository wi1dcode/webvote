<?php

namespace App\Model;

use Core\Model;

class CommentModel extends Model
{
    public function listForPetition($petitionId)
    {
        $stmt = $this->db->prepare('
            SELECT c.id, c.content, c.created_at, c.user_id, u.pseudo
            FROM comments c
            JOIN users u ON u.id = c.user_id
            WHERE c.petition_id = :pid AND c.status = :status
            ORDER BY c.created_at DESC
        ');
        $stmt->execute(['pid' => (int)$petitionId, 'status' => 'VISIBLE']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create($petitionId, $userId, $content)
    {
        $stmt = $this->db->prepare('
            INSERT INTO comments (petition_id, user_id, content, status, created_at)
            VALUES (:pid, :uid, :content, :status, NOW())
        ');
        return $stmt->execute([
            'pid' => (int)$petitionId,
            'uid' => (int)$userId,
            'content' => $content,
            'status' => 'VISIBLE'
        ]);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM comments WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => (int)$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM comments WHERE id = :id');
        return $stmt->execute(['id' => (int)$id]);
    }
}
