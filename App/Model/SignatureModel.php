<?php

namespace App\Model;

use Core\Model;

class SignatureModel extends Model
{
    public function hasSigned($petitionId, $userId)
    {
        $stmt = $this->db->prepare('SELECT id FROM signatures WHERE petition_id = :petition_id AND user_id = :user_id LIMIT 1');
        $stmt->execute(['petition_id' => (int)$petitionId, 'user_id' => (int)$userId]);
        return (bool)$stmt->fetchColumn();
    }

    public function create($petitionId, $userId)
    {
        $stmt = $this->db->prepare('INSERT INTO signatures (petition_id, user_id, created_at) VALUES (:petition_id, :user_id, NOW())');
        return $stmt->execute(['petition_id' => (int)$petitionId, 'user_id' => (int)$userId]);
    }

    public function delete($petitionId, $userId)
    {
        $stmt = $this->db->prepare('DELETE FROM signatures WHERE petition_id = :petition_id AND user_id = :user_id');
        return $stmt->execute(['petition_id' => (int)$petitionId, 'user_id' => (int)$userId]);
    }
}
