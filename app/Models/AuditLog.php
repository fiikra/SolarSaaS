<?php

namespace App\Models;

use App\Core\Model;

class AuditLog extends Model
{
    public function create($data)
    {
        $this->db->query('INSERT INTO audit_logs (user_id, action, details, ip_address) VALUES (:user_id, :action, :details, :ip_address)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':action', $data['action']);
        $this->db->bind(':details', $data['details']);
        $this->db->bind(':ip_address', $data['ip_address']);
        return $this->db->execute();
    }

    public function getLogs($limit = 50)
    {
        $this->db->query('
            SELECT al.*, u.name as user_name, u.email as user_email
            FROM audit_logs al
            LEFT JOIN users u ON al.user_id = u.id
            ORDER BY al.created_at DESC
            LIMIT :limit
        ');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }
}
