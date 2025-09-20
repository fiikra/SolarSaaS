<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Component;

class DimensioningController extends Controller {
    private $projectModel;
    private $settingModel;
    private $componentModel;

    public function __construct() {
        $this->protect();
        $this->projectModel = $this->model('Project');
        $this->settingModel = $this->model('Setting');
        $this->componentModel = $this->model('Component');
    }

    public function calculate($project_id) {
        $project = $this->projectModel->findByIdAndClientId($project_id, $_SESSION['client_id']);
        if (!$project) {
            $this->view('errors/404');
            return;
        }

        $settings = $this->settingModel->findByClientId($_SESSION['client_id']);
        
        // 1. Total Energy Needed
        $totalEnergyNeeded = $project->total_daily_consumption / $settings->system_loss_factor;

        // 2. Panel Sizing
        $peakPowerRequired = $totalEnergyNeeded / $project->psh;

        // 3. Battery Sizing
        $batteryCapacity = ($project->total_daily_consumption * $settings->days_of_autonomy) / ($settings->battery_dod * 12); // Assuming 12V system for now

        // 4. Inverter Sizing (simplified)
        // Sum of power of all appliances that could run simultaneously.
        // This is a complex topic, so we'll use a simplified approach: 125% of total consumption for peak load.
        $inverterSize = $project->total_daily_consumption * 1.25 / 24; // Simplified average load * 1.25

        $data = [
            'project' => $project,
            'settings' => $settings,
            'total_energy_needed' => $totalEnergyNeeded,
            'peak_power_required' => $peakPowerRequired,
            'battery_capacity' => $batteryCapacity,
            'inverter_size' => $inverterSize,
            'panels' => $this->componentModel->findAllByTypeAndClientId('panel', $_SESSION['client_id']),
            'batteries' => $this->componentModel->findAllByTypeAndClientId('battery', $_SESSION['client_id']),
            'inverters' => $this->componentModel->findAllByTypeAndClientId('inverter', $_SESSION['client_id']),
            'controllers' => $this->componentModel->findAllByTypeAndClientId('controller', $_SESSION['client_id']),
        ];

        $this->view('dimensioning/result', $data);
    }

    public function selectComponents($project_id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $projectComponentModel = $this->model('ProjectComponent');
            $componentModel = $this->model('Component');

            // Clear existing components for this project to avoid duplicates
            $projectComponentModel->deleteByProjectId($project_id);

            foreach ($_POST['components'] as $component_id => $quantity) {
                if ($quantity > 0) {
                    $component = $componentModel->findByIdAndClientId($component_id, $_SESSION['client_id']);
                    if ($component) {
                        $projectComponentModel->create([
                            'project_id' => $project_id,
                            'component_id' => $component_id,
                            'quantity' => $quantity,
                            'unit_price' => $component->price
                        ]);
                    }
                }
            }
            $this->redirect('project/show/' . $project_id);
        } else {
            $this->redirect('project/dimensioning/' . $project_id);
        }
    }
}
