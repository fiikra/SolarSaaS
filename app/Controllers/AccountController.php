<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\CSRF;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Role;
use App\Core\Auth;

class AccountController extends Controller {
    private $userModel;
    private $subscriptionModel;
    private $roleModel;

    public function __construct() {
        Auth::check('manage_users'); // Only users with this permission can access this controller
        $this->userModel = $this->model('User');
        $this->subscriptionModel = $this->model('Subscription');
        $this->roleModel = $this->model('Role');
    }

    public function index() {
        $clientId = $_SESSION['client_id'];
        $users = $this->userModel->getUsersByClientId($clientId);
        $subscription = $this->subscriptionModel->findByClientId($clientId);
        $userCount = $this->userModel->countByClientId($clientId);
        $roles = $this->roleModel->findAll();

        $data = [
            'users' => $users,
            'subscription' => $subscription,
            'user_count' => $userCount,
            'roles' => $roles
        ];

        $this->view('account/index', $data);
    }

    public function addUser(Request $request) {
        if (!$request->isPost()) {
            $this->redirect('account');
        }

        $body = $request->getBody();
        $clientId = $_SESSION['client_id'];

        if (!CSRF::verifyToken($body['csrf_token'])) {
            die('CSRF token validation failed.');
        }

        // Check subscription limit
        $subscription = $this->subscriptionModel->findByClientId($clientId);
        $userCount = $this->userModel->countByClientId($clientId);

        if ($userCount >= $subscription->max_users) {
            // Handle limit reached
            $this->redirect('account?error=limit_reached');
            return;
        }

        // Validation
        $errors = [];
        if (empty($body['name'])) $errors['name'] = 'Name is required';
        if (filter_var($body['email'], FILTER_VALIDATE_EMAIL) === false) $errors['email'] = 'Invalid email';
        if ($this->userModel->findByEmail($body['email'])) $errors['email_exists'] = 'Email already in use';
        if (strlen($body['password']) < 6) $errors['password'] = 'Password must be at least 6 characters';

        if (!empty($errors)) {
            // Redirect with errors
            $queryString = http_build_query(['errors' => $errors]);
            $this->redirect('account?' . $queryString);
            return;
        }

        $this->userModel->create([
            'client_id' => $clientId,
            'name' => $body['name'],
            'email' => $body['email'],
            'password' => password_hash($body['password'], PASSWORD_DEFAULT),
            'role_id' => $body['role_id'] ?? 3 // Default to Technician
        ]);

        $this->redirect('account');
    }

    public function deleteUser($id) {
        $clientId = $_SESSION['client_id'];
        $userToDelete = $this->userModel->findById($id);

        // Prevent admin from deleting themselves
        if ($userToDelete && $userToDelete->id == $_SESSION['user_id']) {
            $this->redirect('account?error=self_delete');
            return;
        }

        $this->userModel->delete($id, $clientId);
        $this->redirect('account');
    }
}
