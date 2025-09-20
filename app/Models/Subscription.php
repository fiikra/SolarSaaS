<?php

namespace App\Models;

use App\Core\Model;

class Subscription extends Model
{
    protected $tableName = 'subscriptions';

    /**
     * Get all subscriptions with client company name.
     *
     * @return array
     */
    public function getAllSubscriptionsWithClient()
    {
        $this->db->query("
            SELECT s.*, c.company_name 
            FROM {$this->tableName} s
            JOIN clients c ON s.client_id = c.id
            ORDER BY s.created_at DESC
        ");
        return $this->db->resultSet();
    }

    /**
     * Find a subscription by its ID.
     *
     * @param int $id
     * @return object|false
     */
    public function findById($id)
    {
        $this->db->query("SELECT * FROM {$this->tableName} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Update a subscription's details.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data)
    {
        $this->db->query("
            UPDATE {$this->tableName} 
            SET plan_name = :plan_name, max_users = :max_users, start_date = :start_date, end_date = :end_date, status = :status
            WHERE id = :id
        ");

        $this->db->bind(':id', $id);
        $this->db->bind(':plan_name', $data['plan_name']);
        $this->db->bind(':max_users', $data['max_users']);
        $this->db->bind(':start_date', $data['start_date']);
        $this->db->bind(':end_date', $data['end_date']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }
    
    public function createDefault($client_id) {
        $this->db->query('INSERT INTO subscriptions (client_id, plan_name, max_users, start_date, end_date, status) VALUES (:client_id, :plan_name, :max_users, :start_date, :end_date, :status)');
        $this->db->bind(':client_id', $client_id);
        $this->db->bind(':plan_name', 'default');
        $this->db->bind(':max_users', 1);
        $this->db->bind(':start_date', date('Y-m-d'));
        $this->db->bind(':end_date', date('Y-m-d', strtotime('+1 year')));
        $this->db->bind(':status', 'active');
        
        return $this->db->execute();
    }

    public function findByClientId($client_id) {
        $this->db->query('SELECT * FROM subscriptions WHERE client_id = :client_id ORDER BY end_date DESC LIMIT 1');
        $this->db->bind(':client_id', $client_id);
        return $this->db->single();
    }
}
