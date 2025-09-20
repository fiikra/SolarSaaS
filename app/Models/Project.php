<?php

namespace App\Models;

use App\Core\Model;

class Project extends Model {
    public function create($data) {
        $this->db->query('INSERT INTO projects (user_id, client_id, region_id, project_name, customer_name) VALUES (:user_id, :client_id, :region_id, :project_name, :customer_name)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':client_id', $data['client_id']);
        $this->db->bind(':region_id', $data['region_id']);
        $this->db->bind(':project_name', $data['project_name']);
        $this->db->bind(':customer_name', $data['customer_name']);
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function findAllByClientId($client_id) {
        $this->db->query('SELECT p.*, r.name as region_name FROM projects p JOIN regions r ON p.region_id = r.id WHERE p.client_id = :client_id ORDER BY p.created_at DESC');
        $this->db->bind(':client_id', $client_id);
        return $this->db->resultSet();
    }

    public function findByIdAndClientId($id, $client_id) {
        $this->db->query('SELECT p.*, r.name as region_name, r.psh FROM projects p JOIN regions r ON p.region_id = r.id WHERE p.id = :id AND p.client_id = :client_id');
        $this->db->bind(':id', $id);
        $this->db->bind(':client_id', $client_id);
        return $this->db->single();
    }

    public function countByClientId($client_id) {
        $this->db->query('SELECT COUNT(*) as project_count FROM projects WHERE client_id = :client_id');
        $this->db->bind(':client_id', $client_id);
        return $this->db->single()->project_count;
    }

    public function getLatestByClientId($client_id, $limit) {
        $this->db->query('SELECT * FROM projects WHERE client_id = :client_id ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':client_id', $client_id);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function delete($id, $client_id) {
        $this->db->query('DELETE FROM projects WHERE id = :id AND client_id = :client_id');
        $this->db->bind(':id', $id);
        $this->db->bind(':client_id', $client_id);
        return $this->db->execute();
    }

    public function getMonthlyProjectCounts($client_id) {
        $this->db->query("
            SELECT 
                DATE_FORMAT(created_at, '%Y-%m') as month, 
                COUNT(id) as project_count 
            FROM 
                projects 
            WHERE 
                client_id = :client_id 
            GROUP BY 
                DATE_FORMAT(created_at, '%Y-%m') 
            ORDER BY 
                month ASC
        ");
        $this->db->bind(':client_id', $client_id);
        return $this->db->resultSet();
    }

    public function countAll() {
        $this->db->query('SELECT COUNT(*) as count FROM projects');
        return $this->db->single()->count;
    }
}
