<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Logger;
use PragmaRX\Google2FAQRCode\Google2FA;
use App\Models\User;

class TwoFactorAuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->protect();
        $this->userModel = $this->model('User');
    }

    public function setup()
    {
        $google2fa = new Google2FA();
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);

        $secretKey = $google2fa->generateSecretKey();
        $_SESSION['2fa_secret'] = $secretKey;

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            'SolarSaaS',
            $user->email,
            $secretKey
        );

        $this->view('auth/2fa_setup', ['qrCodeUrl' => $qrCodeUrl, 'secretKey' => $secretKey]);
    }

    public function enable(Request $request)
    {
        $google2fa = new Google2FA();
        $userId = $_SESSION['user_id'];
        $secret = $_SESSION['2fa_secret'];
        $otp = $request->getBody()['otp'];

        if ($google2fa->verifyKey($secret, $otp)) {
            $this->userModel->enable2FA($userId, $secret);
            unset($_SESSION['2fa_secret']);
            Logger::log('2FA Enabled', "User ID {$userId} enabled 2FA.");
            $this->redirect('profile'); // Or wherever you manage user profile
        } else {
            Logger::log('2FA Enable Failed', "User ID {$userId} failed to enable 2FA with wrong OTP.");
            $this->redirect('2fa/setup?error=invalid_otp');
        }
    }

    public function disable(Request $request)
    {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);
        $password = $request->getBody()['password'];

        if (password_verify($password, $user->password)) {
            $this->userModel->disable2FA($userId);
            Logger::log('2FA Disabled', "User ID {$userId} disabled 2FA.");
            $this->redirect('profile');
        } else {
            Logger::log('2FA Disable Failed', "User ID {$userId} failed to disable 2FA with wrong password.");
            $this->redirect('profile?error=wrong_password');
        }
    }

    public function verify()
    {
        $this->view('auth/2fa_verify');
    }

    public function doVerify(Request $request)
    {
        $google2fa = new Google2FA();
        $userId = $_SESSION['2fa_user_id'];
        $user = $this->userModel->findById($userId);
        $otp = $request->getBody()['otp'];

        if ($google2fa->verifyKey($user->google2fa_secret, $otp)) {
            // OTP is correct, create the final user session
            unset($_SESSION['2fa_user_id']);
            $this->createUserSession($user); // You need to implement this method or copy from AuthController
            Logger::log('User Login (2FA)', "User {$user->email} logged in successfully with 2FA.");
            $this->redirect('dashboard');
        } else {
            Logger::log('2FA Login Failed', "Failed 2FA login attempt for user {$user->email}.");
            $this->redirect('2fa/verify?error=invalid_otp');
        }
    }

    // This is a helper method that should be consistent with AuthController
    private function createUserSession($user) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['client_id'] = $user->client_id;
        $_SESSION['user_role'] = $user->role_name;
        $_SESSION['user_permissions'] = $this->model('Permission')->getByRoleId($user->role_id);
        $this->userModel->updateLastLogin($user->id);
    }
}
