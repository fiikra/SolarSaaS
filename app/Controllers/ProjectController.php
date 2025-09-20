<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\CSRF;
use App\Models\Project;
use App\Models\Region;
use App\Models\Appliance;
use App\Models\ProjectComponent;
use App\Models\Component;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Core\Auth;
use App\Models\Notification;
use App\Models\Inventory;
use App\Models\ProjectFile;

class ProjectController extends Controller {
    private $projectModel;
    private $regionModel;
    private $applianceModel;
    private $projectComponentModel;
    private $componentModel;
    private $notificationModel;
    private $inventoryModel;
    private $projectFileModel;

    public function __construct() {
        $this->protect();
        $this->projectModel = $this->model('Project');
        $this->regionModel = $this->model('Region');
        $this->applianceModel = $this->model('Appliance');
        $this->projectComponentModel = $this->model('ProjectComponent');
        $this->componentModel = $this->model('Component');
        $this->notificationModel = $this->model('Notification');
        $this->inventoryModel = $this->model('Inventory');
        $this->projectFileModel = $this->model('ProjectFile');
    }

    public function index() {
        Auth::check('view_projects');
        $projects = $this->projectModel->findAllByClientId($_SESSION['client_id']);
        $this->view('projects/index', ['projects' => $projects]);
    }

    public function create() {
        Auth::check('manage_projects');
        $regions = $this->regionModel->findAll();
        $this->view('projects/create', ['regions' => $regions]);
    }

    public function store() {
        $request = new Request();
        Auth::check('manage_projects');
        if (!$request->isPost()) {
            $this->redirect('projects');
        }

        $body = $request->getBody();

        if (!CSRF::verifyToken($body['csrf_token'])) {
            die('CSRF token validation failed.');
        }

        $data = [
            'user_id' => $_SESSION['user_id'],
            'client_id' => $_SESSION['client_id'],
            'region_id' => $body['region_id'],
            'project_name' => $body['project_name'],
            'customer_name' => $body['customer_name']
        ];

        $projectId = $this->projectModel->create($data);
        if ($projectId) {
            // Notify admin/project manager
            $this->notifyProjectCreation($projectId, $data['project_name']);
            $this->redirect('project/show/' . $projectId);
        } else {
            $regions = $this->regionModel->findAll();
            $this->view('projects/create', ['error' => 'Failed to create project.', 'regions' => $regions, 'data' => $body]);
        }
    }

    public function show($id) {
        Auth::check('view_projects');
        $project = $this->projectModel->findByIdAndClientId($id, $_SESSION['client_id']);
        if (!$project) {
            $this->view('errors/404');
            return;
        }

        $appliances = $this->applianceModel->findAllByProjectId($id);
        $projectComponents = $this->projectComponentModel->findAllByProjectId($id);
        $availableComponents = $this->componentModel->findAllByClientId($_SESSION['client_id']);
        $projectFiles = $this->projectFileModel->findByProjectId($id);

        $data = [
            'project' => $project,
            'appliances' => $appliances,
            'project_components' => $projectComponents,
            'available_components' => $availableComponents,
            'project_files' => $projectFiles
        ];

        $this->view('projects/show', $data);
    }

    public function estimate($id) {
        Auth::check('view_projects');
        $project = $this->projectModel->findByIdAndClientId($id, $_SESSION['client_id']);
        if (!$project) {
            $this->view('errors/404');
            return;
        }
        $projectComponents = $this->projectComponentModel->findAllByProjectId($id);

        $this->view('projects/estimate', [
            'project' => $project,
            'project_components' => $projectComponents
        ]);
    }

    public function generatePdf($id) {
        Auth::check('view_projects');
        $project = $this->projectModel->findByIdAndClientId($id, $_SESSION['client_id']);
        if (!$project) {
            $this->view('errors/404');
            return;
        }
        $projectComponents = $this->projectComponentModel->findAllByProjectId($id);

        // Path to the view file for the PDF content
        $viewPath = APPROOT . '/Views/projects/estimate_pdf.php';

        // Data to be passed to the view
        $data = [
            'project' => $project,
            'project_components' => $projectComponents
        ];

        // Get the HTML content from the view
        ob_start();
        extract($data);
        require($viewPath);
        $html = ob_get_clean();

        // Configure Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("estimate-{$project->project_name}.pdf", ["Attachment" => false]);
    }

    public function addComponent($project_id, Request $request) {
        Auth::check('manage_projects');
        if ($request->isPost()) {
            $body = $request->getBody();
            if (!CSRF::verifyToken($body['csrf_token'])) {
                die('CSRF token validation failed.');
            }

            $data = [
                'project_id' => $project_id,
                'component_id' => $body['component_id'],
                'quantity' => $body['quantity']
            ];

            // Check stock
            $inventoryItem = $this->inventoryModel->findByComponentId($data['component_id']);
            if (!$inventoryItem || $inventoryItem->quantity < $data['quantity']) {
                $this->redirect('project/show/' . $project_id . '?error=insufficient_stock');
                return;
            }

            if ($this->projectComponentModel->create($data)) {
                // Decrement stock
                $this->inventoryModel->decrementStock($data['component_id'], $data['quantity']);
            }
        }
        $this->redirect('project/show/' . $project_id);
    }

    public function removeComponent($project_component_id) {
        Auth::check('manage_projects');
        $projectComponent = $this->projectComponentModel->findById($project_component_id);
        if ($projectComponent) {
            $project = $this->projectModel->findByIdAndClientId($projectComponent->project_id, $_SESSION['client_id']);
            if ($project) {
                if ($this->projectComponentModel->delete($project_component_id)) {
                    // Increment stock
                    $this->inventoryModel->incrementStock($projectComponent->component_id, $projectComponent->quantity);
                }
            }
        }
        // If anything fails, redirect to the main projects list for safety
        $this->redirect('projects');
    }

    public function updateStatus($project_id, Request $request) {
        Auth::check('manage_project_status');
        if ($request->isPost()) {
            $body = $request->getBody();
            $status = $body['status'];
            $project = $this->projectModel->findByIdAndClientId($project_id, $_SESSION['client_id']);

            if ($project && $this->projectModel->updateStatus($project_id, $status)) {
                // Notify relevant users
                $this->notifyStatusChange($project_id, $project->project_name, $status);
            }
        }
        $this->redirect('project/show/' . $project_id);
    }

    private function notifyProjectCreation($projectId, $projectName) {
        $usersToNotify = $this->model('User')->findAdminsAndProjectManagers($_SESSION['client_id']);
        foreach ($usersToNotify as $user) {
            $this->notificationModel->create([
                'user_id' => $user->id,
                'client_id' => $_SESSION['client_id'],
                'message' => "New project created: " . htmlspecialchars($projectName),
                'link' => "project/show/{$projectId}"
            ]);
        }
    }

    private function notifyStatusChange($projectId, $projectName, $status) {
        // Notify the user who created the project
        $project = $this->projectModel->findById($projectId);
        if ($project) {
            $this->notificationModel->create([
                'user_id' => $project->user_id,
                'client_id' => $project->client_id,
                'message' => "Project '" . htmlspecialchars($projectName) . "' status updated to: " . htmlspecialchars($status),
                'link' => "project/show/{$projectId}"
            ]);
        }
    }
}
