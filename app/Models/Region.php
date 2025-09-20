<?php

namespace App\Models;

use App\Core\Model;

class Region extends Model {
    public function findAll() {
        $this->db->query('SELECT * FROM regions ORDER BY name ASC');
        return $this->db->resultSet();
    }
}
