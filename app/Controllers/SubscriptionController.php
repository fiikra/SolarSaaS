<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Subscription;
use App\Core\Auth;
use App\Core\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        // Protect all methods in this controller, only admins can access
        if (!Auth::check('manage_settings')) {
            // A more specific permission like 'manage_subscriptions' would be better
            // For now, we reuse 'manage_settings' which is for admins.
            $this->redirect('home');
        }
    }

    /**
     * Display a list of all subscriptions.
     */
    public function index()
    {
        $subscriptionModel = new Subscription();
        $subscriptions = $subscriptionModel->getAllSubscriptionsWithClient();

        $this->view('subscriptions/index', [
            'subscriptions' => $subscriptions
        ]);
    }

    /**
     * Show the form for editing a specific subscription.
     *
     * @param int $id
     */
    public function edit($id)
    {
        $subscriptionModel = new Subscription();
        $subscription = $subscriptionModel->findById($id);

        if (!$subscription) {
            // Handle not found, maybe redirect back with an error
            $this->redirect('subscriptions');
        }

        $this->view('subscriptions/edit', [
            'subscription' => $subscription
        ]);
    }

    /**
     * Update a specific subscription.
     *
     * @param int $id
     */
    public function update($id)
    {
        $request = new Request();
        if ($request->isPost()) {
            $data = $request->getBody();

            $subscriptionModel = new Subscription();
            if ($subscriptionModel->update($id, $data)) {
                // Redirect to the list with a success message
                $this->redirect('subscriptions');
            } else {
                // Redirect back to the edit form with an error message
                $this->redirect('subscriptions/edit/' . $id);
            }
        } else {
            $this->redirect('subscriptions');
        }
    }
}
