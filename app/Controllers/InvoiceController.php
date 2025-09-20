<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Subscription;
use App\Core\Auth;
use App\Core\Request;
use TCPDF;

class InvoiceController extends Controller
{
    public function __construct()
    {
        // A more specific permission like 'manage_billing' would be ideal
        if (!Auth::check('manage_settings')) {
            $this->redirect('home');
        }
    }

    public function index()
    {
        $invoiceModel = new Invoice();
        $invoices = $invoiceModel->getAllInvoicesWithClient();

        $this->view('invoices/index', [
            'invoices' => $invoices
        ]);
    }

    public function show($id)
    {
        $invoiceModel = new Invoice();
        $invoice = $invoiceModel->findByIdWithDetails($id);

        if (!$invoice) {
            $this->redirect('invoices');
        }

        $this->view('invoices/show', [
            'invoice' => $invoice
        ]);
    }

    public function create()
    {
        $clientModel = new Client();
        $clients = $clientModel->findAll();
        
        $subscriptionModel = new Subscription();
        $subscriptions = $subscriptionModel->getAllSubscriptionsWithClient();

        $this->view('invoices/create', [
            'clients' => $clients,
            'subscriptions' => $subscriptions
        ]);
    }

    public function store()
    {
        $request = new Request();
        if ($request->isPost()) {
            $data = $request->getBody();
            
            $invoiceModel = new Invoice();
            $invoiceItemModel = new \App\Models\InvoiceItem();

            $invoiceData = [
                'client_id' => $data['client_id'],
                'subscription_id' => $data['subscription_id'],
                'issue_date' => $data['issue_date'],
                'due_date' => $data['due_date'],
                'amount' => $data['amount'],
                'status' => 'draft',
                'invoice_number' => 'INV-' . time() // Simple unique number
            ];

            $invoiceId = $invoiceModel->create($invoiceData);

            if ($invoiceId) {
                $itemData = [
                    'invoice_id' => $invoiceId,
                    'description' => $data['item_description'],
                    'quantity' => $data['item_quantity'],
                    'unit_price' => $data['item_unit_price'],
                    'total_price' => $data['item_quantity'] * $data['item_unit_price']
                ];
                $invoiceItemModel->create($itemData);
                
                $this->redirect('invoices/show/' . $invoiceId);
            }
        }
        $this->redirect('invoices/create');
    }

    public function markAsPaid($id)
    {
        $invoiceModel = new Invoice();
        $invoiceModel->update($id, ['status' => 'paid']);
        $this->redirect('invoices/show/' . $id);
    }

    public function generatePdf($id)
    {
        $invoiceModel = new Invoice();
        $invoice = $invoiceModel->findByIdWithDetails($id);

        if (!$invoice) {
            $this->redirect('invoices');
            return;
        }

        // Create new PDF document
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('SolarSaaS');
        $pdf->SetAuthor('SolarSaaS');
        $pdf->SetTitle('Invoice ' . $invoice->invoice_number);
        $pdf->SetSubject('Invoice');

        // Add a page
        $pdf->AddPage();

        // Set some content to print
        $html = '<h1>Invoice ' . htmlspecialchars($invoice->invoice_number) . '</h1>' .
            '<p><strong>Client:</strong> ' . htmlspecialchars($invoice->company_name) . '</p>' .
            '<p><strong>Issue Date:</strong> ' . htmlspecialchars($invoice->issue_date) . '</p>' .
            '<p><strong>Due Date:</strong> ' . htmlspecialchars($invoice->due_date) . '</p>' .
            '<p><strong>Total:</strong> $' . number_format($invoice->total_amount, 2) . '</p>' .
            '<p><strong>Status:</strong> ' . ucfirst(htmlspecialchars($invoice->status)) . '</p>';

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // Close and output PDF document
        $pdf->Output('invoice_' . $invoice->invoice_number . '.pdf', 'I');
    }
}
