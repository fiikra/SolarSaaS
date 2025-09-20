<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Project;
use App\Models\Invoice;

class ClientPortalController extends Controller
{
    private $projectModel;
    private $invoiceModel;

    public function __construct()
    {
        if (!Auth::check('client')) {
            $this->redirect('login');
        }
        $this->projectModel = $this->model('Project');
        $this->invoiceModel = $this->model('Invoice');
    }

    /**
     * Show the client dashboard.
     */
    public function index()
    {
        $clientId = $_SESSION['user_id']; // Assuming client's user_id is the client_id in projects/invoices

        $data = [
            'totalProjects' => $this->projectModel->countByClientId($clientId),
            'pendingInvoices' => $this->invoiceModel->countByStatusForClient('pending', $clientId),
            'paidInvoices' => $this->invoiceModel->countByStatusForClient('paid', $clientId),
            'recentProjects' => $this->projectModel->getLatestByClientId($clientId, 5)
        ];

        $this->view('client_portal/dashboard', $data);
    }
}
