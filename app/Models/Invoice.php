<?php

namespace App\Models;

use App\Core\Model;

class Invoice extends Model
{
    protected $tableName = 'invoices';

    public function getAllInvoicesWithClient()
    {
        $this->db->query("
            SELECT i.*, c.company_name 
            FROM {$this->tableName} i
            JOIN clients c ON i.client_id = c.id
            ORDER BY i.issue_date DESC
        ");
        return $this->db->resultSet();
    }

    public function findByIdWithDetails($id)
    {
        $this->db->query("
            SELECT i.*, c.company_name, c.contact_email 
            FROM {$this->tableName} i
            JOIN clients c ON i.client_id = c.id
            WHERE i.id = :id
        ");
        $this->db->bind(':id', $id);
        $invoice = $this->db->single();

        if ($invoice) {
            $this->db->query("SELECT * FROM invoice_items WHERE invoice_id = :invoice_id");
            $this->db->bind(':invoice_id', $id);
            $invoice->items = $this->db->resultSet();
        }

        return $invoice;
    }
    
    public function create($data)
    {
        $this->db->query("
            INSERT INTO {$this->tableName} (client_id, subscription_id, invoice_number, amount, issue_date, due_date, status)
            VALUES (:client_id, :subscription_id, :invoice_number, :amount, :issue_date, :due_date, :status)
        ");

        $this->db->bind(':client_id', $data['client_id']);
        $this->db->bind(':subscription_id', $data['subscription_id']);
        $this->db->bind(':invoice_number', $data['invoice_number']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':issue_date', $data['issue_date']);
        $this->db->bind(':due_date', $data['due_date']);
        $this->db->bind(':status', $data['status']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function update($id, $data)
    {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= "{$key} = :{$key}, ";
        }
        $fields = rtrim($fields, ', ');

        $this->db->query("UPDATE {$this->tableName} SET {$fields} WHERE id = :id");

        $this->db->bind(':id', $id);
        foreach ($data as $key => $value) {
            $this->db->bind(":{$key}", $value);
        }

        return $this->db->execute();
    }

    public function countByStatus($status) {
        $this->db->query("SELECT COUNT(*) as count FROM {$this->tableName} WHERE status = :status");
        $this->db->bind(':status', $status);
        return $this->db->single()->count;
    }

    public function countByStatusForClient($status, $client_id) {
        $this->db->query("SELECT COUNT(*) as count FROM {$this->tableName} WHERE status = :status AND client_id = :client_id");
        $this->db->bind(':status', $status);
        $this->db->bind(':client_id', $client_id);
        $row = $this->db->single();
        return $row ? $row->count : 0;
    }

    public function getLatestByClientId($client_id, $limit) {
        $this->db->query("SELECT * FROM {$this->tableName} WHERE client_id = :client_id ORDER BY issue_date DESC LIMIT :limit");
        $this->db->bind(':client_id', $client_id);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getTotalRevenue() {
        $this->db->query("SELECT SUM(amount) as total FROM {$this->tableName} WHERE status = 'paid'");
        return $this->db->single()->total;
    }
}
