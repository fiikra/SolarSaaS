<div class="p-6 md:p-8 bg-gray-100" id="estimate-content">
    <header class="print:hidden flex flex-col md:flex-row justify-between md:items-center mb-8">
        <div>
            <a href="<?php echo URLROOT; ?>/project/show/<?php echo $data['project']->id; ?>" class="text-solar-blue hover:text-blue-800 font-medium text-sm">
                <i class="fas fa-arrow-left mr-2"></i>Back to Project
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Project Estimate</h1>
        </div>
        <button onclick="window.print()" class="mt-4 md:mt-0 bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors flex items-center shadow-md">
            <i class="fas fa-print mr-2"></i>Print Estimate
        </button>
        <a href="<?php echo URLROOT; ?>/project/generatePdf/<?php echo $data['project']->id; ?>" target="_blank" class="mt-4 md:mt-0 ml-4 bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600 transition-colors flex items-center shadow-md">
            <i class="fas fa-file-pdf mr-2"></i>Download PDF
        </a>
    </header>

    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-xl shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-start border-b-2 border-gray-200 pb-6">
            <div>
                <h2 class="text-3xl font-bold text-solar-blue flex items-center">
                    <i class="fas fa-bolt text-solar-yellow mr-2"></i> SolarSaaS
                </h2>
                <p class="text-gray-500 mt-1">Your Trusted Solar Partner</p>
            </div>
            <div class="text-right">
                <h3 class="text-4xl font-extrabold text-gray-700">ESTIMATE</h3>
                <p class="text-gray-500 mt-1">Date: <?php echo date('M d, Y'); ?></p>
            </div>
        </div>

        <!-- Project & Customer Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 my-8">
            <div>
                <h4 class="font-bold text-gray-500 uppercase tracking-wider text-sm mb-2">Billed To</h4>
                <p class="font-semibold text-gray-800 text-lg"><?php echo htmlspecialchars($data['project']->customer_name); ?></p>
            </div>
            <div class="sm:text-right">
                <h4 class="font-bold text-gray-500 uppercase tracking-wider text-sm mb-2">Project Details</h4>
                <p class="text-gray-700"><strong>Project:</strong> <?php echo htmlspecialchars($data['project']->project_name); ?></p>
                <p class="text-gray-700"><strong>Location:</strong> <?php echo htmlspecialchars($data['project']->region_name); ?></p>
            </div>
        </div>

        <!-- Components Table -->
        <div class="mt-10">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Item / Description</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Qty</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Unit Price</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (!empty($data['project_components'])): ?>
                        <?php foreach ($data['project_components'] as $item): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-800"><?php echo htmlspecialchars(ucfirst($item->type)); ?></p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($item->brand . ' ' . $item->model); ?></p>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-700"><?php echo $item->quantity; ?></td>
                                <td class="px-6 py-4 text-right text-gray-700">$<?php echo number_format($item->unit_price, 2); ?></td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-800">$<?php echo number_format($item->total_price, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center py-10 text-gray-500">No components have been added to this project.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="flex justify-end mt-10">
            <div class="w-full sm:w-1/2 md:w-1/3">
                <div class="space-y-2">
                    <div class="flex justify-between text-gray-700">
                        <span>Subtotal:</span>
                        <span>$<?php echo number_format($data['project']->total_price, 2); ?></span>
                    </div>
                    <!-- You can add Tax, Discounts etc. here -->
                    <div class="flex justify-between text-gray-700">
                        <span>Tax (0%):</span>
                        <span>$0.00</span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t-2 border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-gray-900">TOTAL</span>
                        <span class="text-2xl font-bold text-solar-blue">$<?php echo number_format($data['project']->total_price, 2); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Notes -->
        <div class="mt-12 pt-6 border-t text-center text-gray-500 text-sm">
            <p>Thank you for your business!</p>
            <p>This estimate is valid for 30 days.</p>
        </div>
    </div>
</div>
<style>
    @media print {
        body {
            background-color: white;
        }
        .print\\:hidden {
            display: none;
        }
        #estimate-content {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0;
            margin: 0;
        }
        .shadow-lg {
            box-shadow: none;
        }
    }
</style>
