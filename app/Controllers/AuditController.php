<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AuditLog;
use App\Core\Auth;

class AuditController extends Controller
{
    private $auditLogModel;

    public function __construct()
    {
        $this->protect();
        Auth::check('view_audit_trail');
        $this->auditLogModel = $this->model('AuditLog');
    }

    public function index()
    {
        $logs = $this->auditLogModel->getLogs();
        $this->view('audit/index', ['logs' => $logs]);
    }
}
