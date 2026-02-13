<?php

namespace App\Model;

use Core\Model;

class UserModel extends Model
{
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    public function find($id)
    {
        $stmt = $this->db->prepare('SELECT id, pseudo, email, avatar, role, status, created_at FROM users WHERE id = :id');
        $stmt->execute(['id' => (int)$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    public function create($pseudo, $email, $passwordHash, $avatarPath = null)
    {
        $stmt = $this->db->prepare('INSERT INTO users (pseudo, email, password, avatar, role, status, created_at) VALUES (:pseudo, :email, :password, :avatar, :role, :status, NOW())');
        $stmt->execute([
            'pseudo' => $pseudo,
            'email' => $email,
            'password' => $passwordHash,
            'avatar' => $avatarPath,
            'role' => 'USER',
            'status' => 'ACTIVE'
        ]);
        return (int)$this->getLastInsertId();
    }

    public function updateAvatar($id, $avatarPath)
    {
        $stmt = $this->db->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');
        return $stmt->execute(['avatar' => $avatarPath, 'id' => (int)$id]);
    }

    public function listAll()
    {
        $stmt = $this->db->query('SELECT id, pseudo, email, avatar, role, status, created_at FROM users ORDER BY created_at DESC');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function setStatus($id, $status)
    {
        $stmt = $this->db->prepare('UPDATE users SET status = :status WHERE id = :id');
        return $stmt->execute(['status' => $status, 'id' => (int)$id]);
    }

    
    public function getPasswordHash($id)
    {
        $stmt = $this->db->prepare('SELECT password FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => (int)$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row['password'] ?? null;
    }

    public function updatePassword($id, $passwordHash)
    {
        $stmt = $this->db->prepare('UPDATE users SET password = :password WHERE id = :id');
        return $stmt->execute(['password' => $passwordHash, 'id' => (int)$id]);
    }

public function setRole($id, $role)
    {
        $stmt = $this->db->prepare('UPDATE users SET role = :role WHERE id = :id');
        return $stmt->execute(['role' => $role, 'id' => (int)$id]);
    }
}
