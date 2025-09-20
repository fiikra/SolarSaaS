<?php

namespace App\Models;

use App\Core\Model;

class Appliance extends Model {
    public function create($data) {
        $this->db->query('INSERT INTO project_appliances (project_id, name, power, quantity, daily_usage_hours) VALUES (:project_id, :name, :power, :quantity, :daily_usage_hours)');
        $this->db->bind(':project_id', $data['project_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':power', $data['power']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':daily_usage_hours', $data['daily_usage_hours']);
        return $this->db->execute();
    }

    public function findAllByProjectId($project_id) {
        $this->db->query('SELECT * FROM project_appliances WHERE project_id = :project_id');
        $this->db->bind(':project_id', $project_id);
        return $this->db->resultSet();
    }

    public function findById($id) {
        $this->db->query('SELECT * FROM project_appliances WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function delete($id) {
        // Note: We don't filter by client_id here because the project access is already secured.
        // A user can only delete appliances from a project they have access to.
        $this->db->query('DELETE FROM project_appliances WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
