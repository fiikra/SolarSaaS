<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Project;
use App\Models\Invoice;
use App\Models\Client;

class DashboardController extends Controller
{
    public function __construct()
    {
        if (!Auth::check(['admin', 'staff'])) {
            $this->redirect('login');
        }
    }

    public function index()
    {
        $projectModel = new Project();
        $invoiceModel = new Invoice();
        $clientModel = new Client();

        $data = [
            'activeProjects' => $projectModel->countAll(),
            'pendingInvoices' => $invoiceModel->countByStatus('pending'),
            'newClients' => $clientModel->countNewClients(),
            'totalRevenue' => $invoiceModel->getTotalRevenue() ?? '0.00'
        ];

        $this->view('dashboard/index', $data);
    }
}

