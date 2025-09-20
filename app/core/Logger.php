<?php

namespace App\Core;

use App\Models\AuditLog;

class Logger
{
    public static function log($action, $details = '')
    {
        $auditLogModel = (new Controller)->model('AuditLog');
        
        $userId = $_SESSION['user_id'] ?? null;
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

        $auditLogModel->create([
            'user_id' => $userId,
            'action' => $action,
            'details' => $details,
            'ip_address' => $ipAddress
        ]);
    }
}
