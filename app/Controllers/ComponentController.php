<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\CSRF;
use App\Models\Component;
use App\Core\Auth;

class ComponentController extends Controller {
    private $componentModel;

    public function __construct() {
        $this->protect();
        $this->componentModel = $this->model('Component');
    }

    public function index() {
        Auth::check('manage_components');
        $components = $this->componentModel->findAllByClientId($_SESSION['client_id']);
        $this->view('components/index', ['components' => $components]);
    }

    public function create() {
        Auth::check('manage_components');
        $this->view('components/form', [
            'action' => 'create',
            'title' => 'Add New Component'
        ]);
    }

    public function store(Request $request) {
        Auth::check('manage_components');
        if (!$request->isPost()) {
            $this->redirect('components');
        }

        $body = $request->getBody();
        if (!CSRF::verifyToken($body['csrf_token'])) {
            die('CSRF token validation failed.');
        }

        $specs = $this->buildSpecs($body['type'], $body);

        $data = [
            'client_id' => $_SESSION['client_id'],
            'type' => $body['type'],
            'brand' => $body['brand'],
            'model' => $body['model'],
            'price' => $body['price'],
            'specs' => json_encode($specs)
        ];

        $this->componentModel->create($data);
        $this->redirect('components');
    }

    public function edit($id) {
        Auth::check('manage_components');
        $component = $this->componentModel->findByIdAndClientId($id, $_SESSION['client_id']);
        if (!$component) {
            $this->view('errors/404');
            return;
        }

        $this->view('components/form', [
            'action' => 'edit',
            'title' => 'Edit Component',
            'component' => $component,
            'specs' => json_decode($component->specs, true)
        ]);
    }

    public function update($id, Request $request) {
        Auth::check('manage_components');
        if (!$request->isPost()) {
            $this->redirect('components');
        }

        $body = $request->getBody();
        if (!CSRF::verifyToken($body['csrf_token'])) {
            die('CSRF token validation failed.');
        }

        $specs = $this->buildSpecs($body['type'], $body);

        $data = [
            'id' => $id,
            'client_id' => $_SESSION['client_id'],
            'type' => $body['type'],
            'brand' => $body['brand'],
            'model' => $body['model'],
            'price' => $body['price'],
            'specs' => json_encode($specs)
        ];

        $this->componentModel->update($data);
        $this->redirect('components');
    }

    public function delete($id) {
        Auth::check('manage_components');
        $this->componentModel->delete($id, $_SESSION['client_id']);
        $this->redirect('components');
    }

    private function buildSpecs($type, $body) {
        $specs = [];
        switch ($type) {
            case 'panel':
                $specs['power_watt'] = $body['spec_power_watt'];
                break;
            case 'battery':
                $specs['capacity_ah'] = $body['spec_capacity_ah'];
                $specs['voltage'] = $body['spec_voltage'];
                break;
            case 'inverter':
                $specs['power_watt'] = $body['spec_power_watt'];
                $specs['voltage'] = $body['spec_voltage'];
                break;
            case 'controller':
                $specs['max_current_amp'] = $body['spec_max_current_amp'];
                $specs['voltage'] = $body['spec_voltage'];
                break;
        }
        return $specs;
    }
}
