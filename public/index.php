<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/Language.php';
require_once __DIR__ . '/../app/helpers/language_helper.php';

use App\Core\Router;
use App\Core\Language;

session_start();

// Set language
$lang = $_SESSION['lang'] ?? 'en';
Language::load($lang);

$router = new Router();

// Routes
$router->get('/', 'HomeController@index');

// Auth routes
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@authenticate');
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@store');
$router->get('/logout', 'AuthController@logout');

// Dashboard
$router->get('/dashboard', 'DashboardController@index');

// Account management (admin)
$router->get('/account', 'AccountController@index');
$router->post('/account/add', 'AccountController@addUser');
$router->get('/account/delete/{id}', 'AccountController@deleteUser');

// Settings (admin)
$router->get('/settings', 'SettingController@edit');
$router->post('/settings/update', 'SettingController@update');

// Projects
$router->get('/projects', 'ProjectController@index');
$router->get('/project/create', 'ProjectController@create');
$router->post('/project/store', 'ProjectController@store');
$router->get('/project/show/{id}', 'ProjectController@show');
$router->get('/project/delete/{id}', 'ProjectController@delete');

// Project Appliances
$router->post('/project/{id}/add_appliance', 'ApplianceController@add');
$router->get('/project/appliance/delete/{id}', 'ApplianceController@delete');

// Dimensioning
$router->get('/project/dimensioning/{id}', 'DimensioningController@calculate');
$router->post('/project/dimensioning/select_components/{id}', 'DimensioningController@selectComponents');

// Components (Material)
$router->get('/components', 'ComponentController@index');

// Invoices
$router->get('/invoices', 'InvoiceController@index');
$router->get('/invoices/create', 'InvoiceController@create');
$router->post('/invoices/store', 'InvoiceController@store');
$router->get('/invoices/show/{id}', 'InvoiceController@show');
$router->post('/invoices/markAsPaid/{id}', 'InvoiceController@markAsPaid');
$router->get('/invoices/pdf/{id}', 'InvoiceController@generatePdf');

$router->get('/component/create', 'ComponentController@create');
$router->post('/component/store', 'ComponentController@store');

$router->get('/component/edit/{id}', 'ComponentController@edit');
$router->post('/component/update/{id}', 'ComponentController@update');
$router->get('/component/delete/{id}', 'ComponentController@delete');

// Maintenance
$router->get('/project/maintenance/{id}', 'MaintenanceController@plan');

// Subscriptions (Admin)
$router->get('/subscriptions', 'SubscriptionController@index');
$router->get('/subscriptions/edit/{id}', 'SubscriptionController@edit');
$router->post('/subscriptions/update/{id}', 'SubscriptionController@update');

// Client Portal
$router->get('/portal/dashboard', 'ClientPortalController@index');

// Language Switcher
$router->get('/lang/{lang}', 'LangController@switch');


$router->dispatch();

