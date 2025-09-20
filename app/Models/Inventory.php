<?php

namespace App\Models;

use App\Core\Model;

class Inventory extends Model
{
    public function getInventory($clientId)
    {
        $this->db->query("
            SELECT c.id as component_id, c.brand, c.model, c.type, i.quantity, i.low_stock_threshold, i.last_updated
            FROM components c
            LEFT JOIN inventory i ON c.id = i.component_id
            WHERE c.client_id = :client_id
            ORDER BY c.brand, c.model
        ");
        $this->db->bind(':client_id', $clientId);
        return $this->db->resultSet();
    }

    public function findByComponentId($componentId)
    {
        $this->db->query("SELECT * FROM inventory WHERE component_id = :component_id");
        $this->db->bind(':component_id', $componentId);
        return $this->db->single();
    }

    public function ensureExists($componentId)
    {
        if (!$this->findByComponentId($componentId)) {
            $this->db->query("INSERT INTO inventory (component_id, quantity) VALUES (:component_id, 0)");
            $this->db->bind(':component_id', $componentId);
            $this->db->execute();
        }
    }

    public function updateQuantity($componentId, $quantity, $lowStockThreshold)
    {
        $this->ensureExists($componentId);
        $this->db->query("UPDATE inventory SET quantity = :quantity, low_stock_threshold = :low_stock_threshold WHERE component_id = :component_id");
        $this->db->bind(':component_id', $componentId);
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':low_stock_threshold', $lowStockThreshold);
        return $this->db->execute();
    }

    public function decrementStock($componentId, $quantity)
    {
        $this->ensureExists($componentId);
        $this->db->query("UPDATE inventory SET quantity = quantity - :quantity WHERE component_id = :component_id");
        $this->db->bind(':component_id', $componentId);
        $this->db->bind(':quantity', $quantity);
        return $this->db->execute();
    }

    public function incrementStock($componentId, $quantity)
    {
        $this->ensureExists($componentId);
        $this->db->query("UPDATE inventory SET quantity = quantity + :quantity WHERE component_id = :component_id");
        $this->db->bind(':component_id', $componentId);
        $this->db->bind(':quantity', $quantity);
        return $this->db->execute();
    }
}
