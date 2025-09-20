<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\CSRF;
use App\Models\Inventory;
use App\Core\Auth;

class InventoryController extends Controller
{
    private $inventoryModel;

    public function __construct()
    {
        $this->protect();
        Auth::check('manage_inventory');
        $this->inventoryModel = $this->model('Inventory');
    }

    public function index()
    {
        $inventory = $this->inventoryModel->getInventory($_SESSION['client_id']);
        $this->view('inventory/index', [
            'inventory' => $inventory,
            'csrf_token' => \App\Core\CSRF::generateToken()
        ]);
    }

    public function update(Request $request)
    {
        if ($request->isPost()) {
            $body = $request->getBody();
            if (!CSRF::verifyToken($body['csrf_token'])) {
                die('CSRF token validation failed.');
            }

            $componentId = $body['component_id'];
            $quantity = $body['quantity'];
            $lowStockThreshold = $body['low_stock_threshold'];

            $this->inventoryModel->updateQuantity($componentId, $quantity, $lowStockThreshold);
            
            // Check for low stock and notify
            if ($quantity <= $lowStockThreshold) {
                $this->notifyLowStock($componentId, $quantity);
            }

            $this->redirect('inventory');
        }
    }

    private function notifyLowStock($componentId, $quantity)
    {
        $component = $this->model('Component')->findById($componentId);
        if (!$component) return;

        $message = "Low stock alert for " . htmlspecialchars($component->brand . ' ' . $component->model) . ". Current quantity: " . $quantity;
        
        $usersToNotify = $this->model('User')->findAdminsAndProjectManagers($_SESSION['client_id']);
        foreach ($usersToNotify as $user) {
            $this->model('Notification')->create([
                'user_id' => $user->id,
                'client_id' => $_SESSION['client_id'],
                'message' => $message,
                'link' => 'inventory'
            ]);
        }
    }
}
