<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\CSRF;
use App\Models\Setting;
use App\Core\Auth;
use App\Models\Permission;


class SettingController extends Controller {
    private $settingModel;

    public function __construct() {
        Auth::check('manage_settings');
        $this->settingModel = $this->model('Setting');
    }

    public function edit() {
        $clientId = $_SESSION['client_id'];
        $settings = $this->settingModel->findByClientId($clientId);
        $this->view('settings/edit', ['settings' => $settings]);
    }

    public function update(Request $request) {
        if (!$request->isPost()) {
            $this->redirect('settings');
        }

        $body = $request->getBody();
        $clientId = $_SESSION['client_id'];

        if (!CSRF::verifyToken($body['csrf_token'])) {
            die('CSRF token validation failed.');
        }

        $data = [
            'client_id' => $clientId,
            'battery_dod' => $body['battery_dod'],
            'system_loss_factor' => $body['system_loss_factor'],
            'days_of_autonomy' => $body['days_of_autonomy']
        ];

        $this->settingModel->update($data);
        $this->redirect('settings/edit?success=true');
    }
}
