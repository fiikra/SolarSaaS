<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\CSRF;
use App\Models\Appliance;
use App\Models\ProjectAppliance;
use App\Core\Auth;

class ApplianceController extends Controller {
    private $applianceModel;

    public function __construct() {
        $this->protect();
        $this->applianceModel = $this->model('Appliance');
    }

    public function add($project_id, Request $request) {
        Auth::check('manage_projects');
        if ($request->isPost()) {
            $body = $request->getBody();

            if (!CSRF::verifyToken($body['csrf_token'])) {
                die('CSRF token validation failed.');
            }

            $data = [
                'project_id' => $project_id,
                'name' => $body['name'],
                'power' => $body['power'],
                'quantity' => $body['quantity'],
                'daily_usage_hours' => $body['daily_usage_hours']
            ];

            // Simple validation
            if (!empty($data['name']) && !empty($data['power']) && !empty($data['quantity']) && !empty($data['daily_usage_hours'])) {
                if ($this->applianceModel->create($data)) {
                    $this->redirect('project/show/' . $project_id);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->redirect('project/show/' . $project_id . '?error=empty_fields');
            }
        } else {
            $this->redirect('projects');
        }
    }

    public function delete($id) {
        Auth::check('manage_projects');
        $appliance = $this->applianceModel->findById($id); 
        if ($appliance) {
            $project_id = $appliance->project_id;
            // Check if user has access to this project
            $project = $this->model('Project')->findByIdAndClientId($project_id, $_SESSION['client_id']);
            if ($project) {
                if ($this->applianceModel->delete($id)) {
                    $this->redirect('project/show/' . $project_id);
                } else {
                    die('Something went wrong');
                }
            }
        }
        // If anything fails, redirect to the main projects list for safety
        $this->redirect('projects');
    }
}
