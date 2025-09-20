<?php

namespace App\Models;

use App\Core\Model;

class ProjectFile extends Model
{
    public function create($data)
    {
        $this->db->query('INSERT INTO project_files (project_id, user_id, file_name, file_path, file_type) VALUES (:project_id, :user_id, :file_name, :file_path, :file_type)');
        $this->db->bind(':project_id', $data['project_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':file_name', $data['file_name']);
        $this->db->bind(':file_path', $data['file_path']);
        $this->db->bind(':file_type', $data['file_type']);
        return $this->db->execute();
    }

    public function findByProjectId($projectId)
    {
        $this->db->query('
            SELECT pf.*, u.name as uploader_name 
            FROM project_files pf
            LEFT JOIN users u ON pf.user_id = u.id
            WHERE pf.project_id = :project_id 
            ORDER BY pf.uploaded_at DESC
        ');
        $this->db->bind(':project_id', $projectId);
        return $this->db->resultSet();
    }

    public function findById($id)
    {
        $this->db->query('SELECT * FROM project_files WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM project_files WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
