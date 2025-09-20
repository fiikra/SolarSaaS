<?php

namespace App\Models;

use App\Core\Model;

class Client extends Model
{
    protected $table = 'clients';

    /**
     * Crée un nouveau client.
     * @param array $data Les données du client contenant 'company_name' et 'contact_email'.
     * @return string|false L'ID du nouveau client ou false en cas d'échec.
     */
    public function create($data)
    {
        $this->db->query('INSERT INTO clients (company_name, contact_email) VALUES (:company_name, :contact_email)');
        $this->db->bind(':company_name', $data['company_name']);
        $this->db->bind(':contact_email', $data['contact_email']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function findById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function findAll()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY company_name ASC');
        return $this->db->resultSet();
    }

    public function update($data)
    {
        $this->db->query('UPDATE ' . $this->table . ' SET company_name = :company_name, contact_email = :contact_email WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':company_name', $data['company_name']);
        $this->db->bind(':contact_email', $data['contact_email']);

        return $this->db->execute();
    }

    public function countNewClients($days = 30) {
        $this->db->query("SELECT COUNT(*) as count FROM {$this->table} WHERE created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)");
        $this->db->bind(':days', $days);
        return $this->db->single()->count;
    }
}
