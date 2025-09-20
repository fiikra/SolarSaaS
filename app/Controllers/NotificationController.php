<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Notification;
use App\Core\Request;

class NotificationController extends Controller
{
    private $notificationModel;

    public function __construct()
    {
        $this->protect();
        $this->notificationModel = $this->model('Notification');
    }

    public function index()
    {
        $userId = $_SESSION['user_id'];
        $notifications = $this->notificationModel->getByUserId($userId);
        $this->view('notifications/index', ['notifications' => $notifications]);
    }

    public function getUnread()
    {
        $userId = $_SESSION['user_id'];
        $notifications = $this->notificationModel->getUnreadByUserId($userId);
        header('Content-Type: application/json');
        echo json_encode($notifications);
    }

    public function markAsRead($id)
    {
        $userId = $_SESSION['user_id'];
        $this->notificationModel->markAsRead($id, $userId);
        // Redirect back or send a JSON response
        $this->redirect($_SERVER['HTTP_REFERER'] ?? 'notifications');
    }

    public function markAllAsRead()
    {
        $userId = $_SESSION['user_id'];
        $this->notificationModel->markAllAsRead($userId);
        $this->redirect('notifications');
    }
}
