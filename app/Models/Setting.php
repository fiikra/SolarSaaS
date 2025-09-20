<?php

namespace App\Models;

use App\Core\Model;

class Setting extends Model {
    public function createDefault($client_id) {
        $this->db->query('INSERT INTO settings (client_id) VALUES (:client_id)');
        $this->db->bind(':client_id', $client_id);
        return $this->db->execute();
    }

    public function findByClientId($client_id) {
        $this->db->query('SELECT * FROM settings WHERE client_id = :client_id');
        $this->db->bind(':client_id', $client_id);
        return $this->db->single();
    }

    public function update($data) {
        $this->db->query('UPDATE settings SET battery_dod = :battery_dod, system_loss_factor = :system_loss_factor, days_of_autonomy = :days_of_autonomy WHERE client_id = :client_id');
        $this->db->bind(':client_id', $data['client_id']);
        $this->db->bind(':battery_dod', $data['battery_dod']);
        $this->db->bind(':system_loss_factor', $data['system_loss_factor']);
        $this->db->bind(':days_of_autonomy', $data['days_of_autonomy']);
        return $this->db->execute();
    }
}
