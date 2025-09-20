<?php

namespace App\Models;

use App\Core\Model;

class Role extends Model
{
    protected $table = 'roles';

    public function findAll()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }
}
