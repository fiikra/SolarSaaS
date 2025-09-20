<?php

namespace App\Models;

use App\Core\Model;

class InvoiceItem extends Model
{
    protected $tableName = 'invoice_items';

    public function create($data)
    {
        $this->db->query("
            INSERT INTO {$this->tableName} (invoice_id, description, quantity, unit_price, total_price)
            VALUES (:invoice_id, :description, :quantity, :unit_price, :total_price)
        ");

        $this->db->bind(':invoice_id', $data['invoice_id']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':unit_price', $data['unit_price']);
        $this->db->bind(':total_price', $data['total_price']);

        return $this->db->execute();
    }
}
