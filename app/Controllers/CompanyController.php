<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Client;
use App\Models\Subscription;

class CompanyController extends Controller
{
    private $clientModel;
    private $subscriptionModel;

    public function __construct()
    {
        $this->protect();
        // Ensure only admins can access this section
        if ($_SESSION['user_role'] !== 'admin') {
            $this->redirect('/dashboard');
        }

        $this->clientModel = $this->model('Client');
        $this->subscriptionModel = $this->model('Subscription');
    }

    public function index()
    {
        $clientId = $_SESSION['client_id'];
        $company = $this->clientModel->findById($clientId);
        $subscription = $this->subscriptionModel->findByClientId($clientId);

        $data = [
            'company' => $company,
            'subscription' => $subscription
        ];

        $this->view('company/index', $data);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $_SESSION['client_id'],
                'company_name' => trim($_POST['company_name']),
                'contact_email' => trim($_POST['contact_email']),
                'company_name_err' => '',
                'contact_email_err' => ''
            ];

            // Validate data
            if (empty($data['company_name'])) {
                $data['company_name_err'] = 'Please enter company name';
            }
            if (empty($data['contact_email'])) {
                $data['contact_email_err'] = 'Please enter contact email';
            }

            // Make sure no errors
            if (empty($data['company_name_err']) && empty($data['contact_email_err'])) {
                // Validated
                if ($this->clientModel->update($data)) {
                    $this->setFlash('success', 'Company profile updated successfully.');
                    $this->redirect('/company');
                } else {
                    die('Something went wrong.');
                }
            } else {
                // Load view with errors
                $clientId = $_SESSION['client_id'];
                $data['company'] = $this->clientModel->findById($clientId);
                $data['subscription'] = $this->subscriptionModel->findByClientId($clientId);
                $this->view('company/index', $data);
            }
        } else {
            $this->redirect('/company');
        }
    }
}
