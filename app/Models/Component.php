<?php

namespace App\Models;

use App\Core\Model;

class Component extends Model {
    public function create($data) {
        $this->db->query('INSERT INTO components (client_id, type, brand, model, specs, price) VALUES (:client_id, :type, :brand, :model, :specs, :price)');
        $this->db->bind(':client_id', $data['client_id']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':brand', $data['brand']);
        $this->db->bind(':model', $data['model']);
        $this->db->bind(':specs', $data['specs']);
        $this->db->bind(':price', $data['price']);
        return $this->db->execute();
    }

    public function findById($id) {
        $this->db->query('SELECT * FROM components WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function findByIdAndClientId($id, $clientId) {
        $this->db->query('SELECT * FROM components WHERE id = :id AND client_id = :client_id');
        $this->db->bind(':id', $id);
        $this->db->bind(':client_id', $clientId);
        return $this->db->single();
    }

    public function findAllByClientId($clientId) {
        $this->db->query('SELECT * FROM components WHERE client_id = :client_id ORDER BY type, brand, model');
        $this->db->bind(':client_id', $clientId);
        return $this->db->resultSet();
    }

    public function findAllByTypeAndClientId($type, $clientId) {
        $this->db->query('SELECT * FROM components WHERE type = :type AND client_id = :client_id ORDER BY brand, model');
        $this->db->bind(':type', $type);
        $this->db->bind(':client_id', $clientId);
        return $this->db->resultSet();
    }

    public function countByClientId($clientId) {
        $this->db->query('SELECT COUNT(*) as count FROM components WHERE client_id = :client_id');
        $this->db->bind(':client_id', $clientId);
        return $this->db->single()->count;
    }

    public function update($data) {
        $this->db->query('UPDATE components SET type = :type, brand = :brand, model = :model, specs = :specs, price = :price WHERE id = :id AND client_id = :client_id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':client_id', $data['client_id']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':brand', $data['brand']);
        $this->db->bind(':model', $data['model']);
        $this->db->bind(':specs', $data['specs']);
        $this->db->bind(':price', $data['price']);
        return $this->db->execute();
    }

    public function delete($id, $client_id) {
        $this->db->query('DELETE FROM components WHERE id = :id AND client_id = :client_id');
        $this->db->bind(':id', $id);
        $this->db->bind(':client_id', $client_id);
        return $this->db->execute();
    }
}
