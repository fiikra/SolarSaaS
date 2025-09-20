<?php

namespace App\Models;

use App\Core\Model;

class MaintenanceTask extends Model {
    public function findByComponentTypes(array $types) {
        if (empty($types)) {
            return [];
        }
        // Always include 'general' tasks
        $types[] = 'general';
        
        $placeholders = implode(',', array_fill(0, count($types), '?'));
        
        $this->db->query("SELECT * FROM maintenance_tasks WHERE component_type IN ($placeholders) ORDER BY frequency, component_type");
        
        foreach ($types as $k => $type) {
            $this->db->bind($k + 1, $type);
        }
        
        return $this->db->resultSet();
    }
}
