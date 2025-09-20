<?php

namespace App\Models;

use App\Core\Model;

class ProjectComponent extends Model {
    public function create($data) {
        $this->db->query('INSERT INTO project_components (project_id, component_id, quantity, unit_price) VALUES (:project_id, :component_id, :quantity, :unit_price)');
        $this->db->bind(':project_id', $data['project_id']);
        $this->db->bind(':component_id', $data['component_id']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':unit_price', $data['unit_price']);
        return $this->db->execute();
    }

    public function findAllByProjectId($project_id) {
        $this->db->query('SELECT pc.*, c.brand, c.model, c.type FROM project_components pc JOIN components c ON pc.component_id = c.id WHERE pc.project_id = :project_id');
        $this->db->bind(':project_id', $project_id);
        return $this->db->resultSet();
    }

    public function deleteByProjectId($project_id) {
        $this->db->query('DELETE FROM project_components WHERE project_id = :project_id');
        $this->db->bind(':project_id', $project_id);
        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query('DELETE FROM project_components WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
