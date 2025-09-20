<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\MaintenanceTask;
use App\Core\Auth;

class MaintenanceController extends Controller {
    private $projectModel;
    private $maintenanceTaskModel;

    public function __construct() {
        $this->protect();
        $this->projectModel = $this->model('Project');
        $this->maintenanceTaskModel = $this->model('MaintenanceTask');
    }

    public function plan($project_id) {
        Auth::check('view_maintenance_schedule');
        $project = $this->projectModel->findByIdAndClientId($project_id, $_SESSION['client_id']);
        if (!$project) {
            $this->view('errors/404');
            return;
        }

        $projectComponents = $this->model('ProjectComponent')->findAllByProjectId($project_id);
        $componentTypes = array_unique(array_column($projectComponents, 'type'));
        
        $tasks = $this->maintenanceTaskModel->findByComponentTypes($componentTypes);

        $this->view('projects/maintenance', [
            'project' => $project,
            'tasks' => $tasks
        ]);
    }
}
