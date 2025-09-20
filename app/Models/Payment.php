<?php

namespace App\Models;

use App\Core\Model;

class Payment extends Model
{
    protected $tableName = 'payments';

    public function create($data)
    {
        $this->db->query("
            INSERT INTO {$this->tableName} (invoice_id, transaction_id, payment_method, amount, status)
            VALUES (:invoice_id, :transaction_id, :payment_method, :amount, :status)
        ");

        $this->db->bind(':invoice_id', $data['invoice_id']);
        $this->db->bind(':transaction_id', $data['transaction_id']);
        $this->db->bind(':payment_method', $data['payment_method']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }
}
