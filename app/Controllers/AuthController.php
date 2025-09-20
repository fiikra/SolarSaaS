<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\CSRF;
use App\Models\User;
use App\Models\Client;
use App\Models\Subscription;
use App\Models\Setting;
use App\Models\Permission;
use App\Core\Logger;

class AuthController extends Controller {
    protected $userModel;
    protected $clientModel;
    protected $subscriptionModel;
    protected $settingModel;
    protected $permissionModel;

    public function __construct() {
        $this->userModel = $this->model('User');
        $this->clientModel = $this->model('Client');
        $this->subscriptionModel = $this->model('Subscription');
        $this->settingModel = $this->model('Setting');
        $this->permissionModel = $this->model('Permission');
    }

    public function login() {
        $this->view('auth/login');
    }

    public function authenticate() {
        $request = new Request();
        if (!$request->isPost()) {
            $this->redirect('login');
        }

        $body = $request->getBody();

        if (!CSRF::verifyToken($body['csrf_token'])) {
            die('CSRF token validation failed.');
        }

        $user = $this->userModel->findByEmail($body['email']);

        if ($user && password_verify($body['password'], $user->password)) {
            // Check if 2FA is enabled
            if ($user->google2fa_enabled) {
                // Store user ID in session and redirect to 2FA verification page
                $_SESSION['2fa_user_id'] = $user->id;
                $this->redirect('2fa/verify');
            } else {
                // No 2FA, log in directly
                $this->createUserSession($user);
                Logger::log('User Login', "User {$user->email} logged in successfully.");

                // Role-based redirect
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'client') {
                    $this->redirect('portal/dashboard');
                } else {
                    $this->redirect('dashboard');
                }
            }
        } else {
            // Set error message
            Logger::log('Login Failed', "Failed login attempt for email {$body['email']}.");
            $this->view('auth/login', ['error' => 'Invalid credentials']);
        }
    }

    public function register() {
        $this->view('auth/register');
    }

    public function store() {
        $request = new Request();
        if (!$request->isPost()) {
            $this->redirect('register');
        }

        $body = $request->getBody();

        if (!CSRF::verifyToken($body['csrf_token'])) {
            die('CSRF token validation failed.');
        }

        // Validation
        $errors = [];
        if (empty($body['company_name'])) $errors['company_name'] = 'Company name is required';
        if (empty($body['name'])) $errors['name'] = 'Your name is required';
        if (filter_var($body['email'], FILTER_VALIDATE_EMAIL) === false) $errors['email'] = 'Invalid email';
        if ($this->userModel->findByEmail($body['email'])) $errors['email_exists'] = 'Email already taken';
        if (strlen($body['password']) < 6) $errors['password'] = 'Password must be at least 6 characters';
        if ($body['password'] !== $body['confirm_password']) $errors['confirm_password'] = 'Passwords do not match';

        if (!empty($errors)) {
            $this->view('auth/register', ['errors' => $errors, 'data' => $body]);
            return;
        }

        // Hash password
        $body['password'] = password_hash($body['password'], PASSWORD_DEFAULT);

        // Transactional Registration
        $db = \App\Core\Database::getInstance();
        try {
            $db->beginTransaction();

            // 1. Create Client
            $clientId = $this->clientModel->create([
                'company_name' => $body['company_name'],
                'contact_email' => $body['email']
            ]);

            // 2. Create User
            $userId = $this->userModel->create([
                'client_id' => $clientId,
                'name' => $body['name'],
                'email' => $body['email'],
                'password' => $body['password'],
            ]);

            // 3. Create Subscription
            $this->subscriptionModel->createDefault($clientId);

            // 4. Create Settings
            $this->settingModel->createDefault($clientId);

            $db->endTransaction();

            // Automatically log in the new user
            $user = $this->userModel->findById($userId);
            $this->createUserSession($user);
            Logger::log('User Registration', "New user {$user->email} registered and logged in.");
            $this->redirect('dashboard');

        } catch (\Exception $e) {
            $db->cancelTransaction();
            // Log error $e->getMessage()
            $this->view('auth/register', ['error' => 'Registration failed. Please try again.']);
        }
    }

    public function logout() {
        Logger::log('User Logout', "User {$_SESSION['user_email']} logged out.");
        session_unset();
        session_destroy();
        $this->redirect('');
    }

    private function createUserSession($user) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['client_id'] = $user->client_id;
        $_SESSION['user_role'] = $user->role_name;
        $_SESSION['user_permissions'] = $this->permissionModel->getByRoleId($user->role_id);
        $this->userModel->updateLastLogin($user->id);
    }
}
