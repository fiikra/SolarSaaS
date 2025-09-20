<?php

namespace App\Models;

use App\Core\Model;

class Notification extends Model
{
    public function create($data)
    {
        $this->db->query('INSERT INTO notifications (user_id, client_id, message, link) VALUES (:user_id, :client_id, :message, :link)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':client_id', $data['client_id']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':link', $data['link']);
        return $this->db->execute();
    }

    public function getUnreadByUserId($userId)
    {
        $this->db->query('SELECT * FROM notifications WHERE user_id = :user_id AND is_read = 0 ORDER BY created_at DESC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function getByUserId($userId, $limit = 10)
    {
        $this->db->query('SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function markAsRead($id, $userId)
    {
        $this->db->query('UPDATE notifications SET is_read = 1 WHERE id = :id AND user_id = :user_id');
        $this->db->bind(':id', $id);
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }

    public function markAllAsRead($userId)
    {
        $this->db->query('UPDATE notifications SET is_read = 1 WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }
}
