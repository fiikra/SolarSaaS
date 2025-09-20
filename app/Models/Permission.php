<?php

namespace App\Models;

use App\Core\Model;

class Permission extends Model
{
    public function getByRoleId($roleId)
    {
        $this->db->query("SELECT p.name 
                          FROM permissions p
                          JOIN role_permissions rp ON p.id = rp.permission_id
                          WHERE rp.role_id = :role_id");
        $this->db->bind(':role_id', $roleId);
        $results = $this->db->resultSet();
        return array_column($results, 'name');
    }
}
